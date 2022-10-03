<?php

namespace App\Http\Controllers;

use App\Http\Resources\project\ProjectContactResource;
use App\Http\Resources\project\ProjectResource;
use App\Imports\ContactsImport;
use App\Models\Contacts\BaseRecord;
use App\Models\Payments\Invoice;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectContact;
use App\Models\Taxonomy\Field;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use YooKassa\Client;

class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function list(Request $request)
    {
        $userOnly = $request->get('userOnly', false);
        $page = $request->get('page', 1);
        $perPage = $request->get('perPage', 500);
        $search = $request->get('search', '');
        $filter = $request->get('filter', 'all');
        $orderBy = $request->get('orderBy', 'id');
        $includeArchived = $request->get('includeArchived', 'false');

        $query = $userOnly
            ? Auth::user()->projects()
            : Project::query();

        if (Auth::user()->role == User::ROLE_CLIENT) {
            $query = Project::query()->where('user_id', Auth::user()->id);
        }

        if (Auth::user()->role == User::ROLE_EMPLOYEE) {
            $query->where(DB::raw('projects.status'), Project::STATUS_MODERATED);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q
                    ->where('company_name', 'like', "%$search%")
                    ->orWhere('site_url', 'like', "%$search%")
                    ->orWhere('address', 'like', "%$search%")
                    ->orWhere('seo_name', 'like', "%$search%");
            });
        }

        if ($filter != 'all') {
            if ($filter == 'free') {
                $query->doesntHave('users');
            }

            if ($filter == 'taken') {
                $query->has('users');
            }
        }

        if ($orderBy) {
            $query->orderBy($orderBy, 'desc');
        }

        if (!$userOnly) {
            $query->withCount(['viewers as opened_by_me' => function ($q) {
                $q->where('users.id', Auth::user()->id);
            }]);

            $query->withCount(['users as my_project' => function ($q) {
                $q->where('users.id', Auth::user()->id);
            }]);
        }

        if (!$includeArchived) {
            $query->notArchived();
        }

        $query->with(['regions', 'rejectReason']);

        return ProjectResource::collection($query->paginate($perPage));
    }

    public function getInfo(Project $project)
    {
        $project->load(['users' => function ($q) {
            $q->where('users.id', Auth::user()->id);
        },
            'regions',
            'contacts',
            'rejectReason'
        ]);

        $project->viewers()->syncWithoutDetaching([Auth::user()->id]);

        return new ProjectResource($project);
    }

    public function takeProject(Project $project)
    {

        if (Auth::user()->projects()->where('projects.id', $project->id)
            ->exists()) {
            return ['status' => 'already_taken'];
        }

        Auth::user()->projects()->attach($project->id, [
            'taken_at' => now(),
            'status' => Project::STATUS_NEW,
            'status_viewed' => false
        ]);

        return ['status' => 'ok'];

    }

    public function getProjectContacts(Project $project)
    {
        return ProjectContactResource::collection($project->contacts);
    }

    public function updateProjectContacts(Request $request) {
        $data = $request->only(['id', 'names', 'phones']);

        $project = BaseRecord::whereId($data['id'])->firstOrFail();
        $project->names = $data['names'];
        $project->phones = $data['phones'];
        $project->save();

        return response('', 204);
    }

    public function removeProjectContact(Project $project, ProjectContact $contact)
    {
        $project->contacts()->where('id', $contact->id)->delete();

        return ['status' => 'ok'];
    }

    public function saveProjectContact(Project $project, $contactId, Request $request)
    {
        $data = $request->only([
            'project_id',
            'phone',
            'name',
            'comment',
        ]);

        if ($contactId) {
            $contact = ProjectContact::findOrFail($contactId);
            $contact->fill($data);
            $contact->save();
            return new ProjectContactResource($contact);
        }

        $contactId = $project->contacts()->create($data);
        return new ProjectContactResource(ProjectContact::find($contactId));
    }

    /**
     * @param Request $request
     */
    public function createProject(Request $request)
    {
        if (Auth::user()->role != User::ROLE_CLIENT) {
            abort(403, 'Нет права на создание проектов');
        }

        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'regions' => 'nullable|array',
            'lead_criteries' => 'required|array',
            'regionsMain' => 'nullable|array',
            'field_categories' => 'required',
            'b2b' => 'required|array|min:1',
            'firm' => 'nullable',
            'site' => 'nullable',
            'firm_address' => 'nullable',
            'legal_address' => 'nullable',
            'postal_address' => 'nullable',
            'inn' => 'nullable',
            'kpp' => 'nullable',
            'director' => 'nullable',
            'script' => 'required',
            'base' => 'required',
            'leads' => 'required',
            'contacts' => 'nullable|array',
        ]);

//            'regions' => 'nullable|array',
//            'regionsMain' => 'nullable|array',


        $field = Field::find($data['field_categories']['id']);
        $project = new Project();
        $project->user_id = Auth::user()->id;
        $project->company_name = $data['name'];
        $project->description = $data['description'];
//        $project->criteries = $data['lead_criteries'];
        $project->field_id = $field->id;
        $project->b2b = isset($data['b2b']['b2b']);
        $project->legal_name = $data['firm'];
        $project->real_address = $data['firm_address'];
        $project->legal_address = $data['legal_address'];
        $project->inn = $data['inn'];
        $project->kpp = $data['kpp'];
        $project->address = $data['postal_address'];
        $project->ceo_name = $data['director'];
        $project->lead_price = $field->price;
        $project->site_url = $data['site'];
        $project->make_script = $data['script'];
        $project->make_base = $data['base'];
        $project->leads = $data['leads'];

        // Критерии лида
        $cData = [];

        if (!empty($data['lead_criteries'])) {
            $lc = $data['lead_criteries'];

            for ($i = 1; $i <= 5; $i++) {
                if (!empty($lc['lead_criteries_' . $i])) {
                    $cData[] = $i;
                }
            }

            if (!empty($lc['criterion_mounth'])) {
                $project->criterion_month = $lc['criterion_mounth'];
            }

            if (!empty($lc['criterion_price'])) {
                $project->criterion_price = $lc['criterion_price'];
            }

            if (!empty($lc['criterion_position'])) {
                $project->criterion_position = $lc['criterion_position'];
            }
        }

        $project->criteries = $cData;


        $project->save();

        $project->priorityRegions()->sync($data['regionsMain']);
        $regions = collect($data['regions'])->map(function ($region) {
            return $region['id'];
        });
        $project->regions()->sync($regions);

        if (!empty($data['contacts'])) {
            foreach ($data['contacts'] as $c) {
                if (empty($c['company']) || empty($c['phones']) || empty($c['names']))
                    continue;

                $contact = new BaseRecord();
                $contact->company = $c['company'];
                $contact->phones = $c['phones'];
                $contact->names = $c['names'];
                if (!empty($c['info']))
                    $contact->info = $c['info'];

                $contact->project_id = $project->id;
                $contact->save();
            }
        }

        $project->load(['regions', 'priorityRegions', 'contacts']);

        return [
            'error' => 'no',
            'project' => $project,
        ];
    }

    public function createInvoice(Request $request)
    {
        $projectId = $request->get('project_id', null);

//        $project = Project::find($projectId);
//
//        if ($project->user_id != Auth::user()->id) {
//            abort(403, 'Вы не можете изменить данные проект т.к. вы не его создатель');
//        }
//
//        if (!$projectId) {
//            abort(422, 'Не указан project_id');
//        }

        $title = $request->get('title', 'Оплата по проекту №' . $projectId);
        $amount = $request->get('amount', 0);

        if (!$amount) {
            abort(422, 'Сумма по проекту не указана!');
        }

        $type = $request->get('type', Invoice::PAYMENT_TYPE_NOT_SPECIFIED);

        $invoice = new Invoice();
        $invoice->user_id = Auth::user()->id;
        $invoice->project_id = $projectId;
        $invoice->amount = $amount;
        $invoice->type = $type;
        $invoice->status = Invoice::STATUS_NEW;
        $invoice->title = $title;
        $invoice->save();
        $invoice->refresh();

        return $invoice;
    }

    public function invoices(Request $request)
    {
        $from = $request->get('from', now()->subYear());
        $to = $request->get('to', now()->addDay());
        return Invoice::where('user_id', Auth::user()->id)
            ->where('created_at', '>=', $from)
            ->where('created_at', '<', $to)
            ->get();
    }

    public function invoiceUrl(Request $request)
    {
        $invoiceId = $request->get('invoice_id', 0);

        $invoice = Invoice::findOrFail($invoiceId);

        $client = new Client();
        $client->setAuth(config('payments.yoomoney.shopId'), config('payments.yoomoney.key'));

        $payUrl = '';

        $needNew = false;

        // Уже есть номер в платежке, узнаем статус
        if ($invoice->paysys_id) {
            $payment = $client->getPaymentInfo($invoice->paysys_id);

            // Еще нет номера, формируем новый заказ в платежке
            if ($payment->getExpiresAt() && (new Carbon($payment->getExpiresAt()) < now())) {
                // Старуй платеж истек, формируем новый
                $needNew = true;
            } else {
                return [
                    'error' => '',
                    'url' => $payment->confirmation->getConfirmationUrl()
                ];
            }
        } else {
            $needNew = true;
        }

        if ($needNew) {
            $payment = $client->createPayment(
                array(
                    'amount' => array(
                        'value' => $invoice->amount,
                        'currency' => 'RUB',
                    ),
                    'confirmation' => array(
                        'type' => 'redirect',
                        'return_url' => url('/home/finance/'),
//                        'return_url' => url('/cabinet/payments/yoomoney/' . $invoice->id),
                    ),
                    'capture' => true,
                    'description' => $invoice->title,
                ),
                uniqid('', true)
            );

            $invoice->paysys_id = $payment->getId();
            $invoice->save();
            $payUrl = $payment->confirmation->getConfirmationUrl();
        }

        return [
            'error' => '',
            'url' => $payUrl
        ];
    }

    public function contacts(Request $request) {
        $filename = $request->file('file');
        $import = new ContactsImport(false);
        $data = $import->toModels($filename);

        return ProjectContactResource::collection($data);
    }
}

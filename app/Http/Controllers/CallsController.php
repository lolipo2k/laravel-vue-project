<?php

namespace App\Http\Controllers;

use App\Models\Contacts\BaseRecord;
use App\Models\Contacts\BaseRecordStatus;
use App\Models\Projects\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallsController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function requestContact(Request $request)
    {
        $projectId = $request->get('project_id', 0);
        $project = Project::findOrFail($projectId);

        $contact = BaseRecord::where('project_id', $projectId)->whereNull('employee_id')->first();
        $contact->employee_id = Auth::user()->id;
        $contact->save();

        if ($contact) {
            return [
                'status' => 'success',
                'data' => $contact
            ];
        }

        return [
            'status' => 'fail',
            'error' => 'Больше нет контактов по проекту'
        ];
    }

    public function callContact(Request $request)
    {
        return [
            'status' => 'send',
            'id' => '2839fbak3ifgh8bwailfulbofawf'
        ];
    }

    public function callResultRecall(Request $request)
    {
        $contactId = $request->get('contact_id', 0);
        $comment = $request->get('comment', '');
        $nextDate = $request->get('next_date', now()->addDay());
        $contact = BaseRecord::findOrFail($contactId);
        $contact->status = BaseRecord::STATUS_RECALL;
        $contact->save();

        $status = new BaseRecordStatus();
        $status->project_id = $contact->project_id;
        $status->base_record_id = $contact->id;
        $status->employee_id = $contact->employee_id;
        $status->next_date = new Carbon($nextDate);
        $status->status = BaseRecordStatus::STATUS_RECALL;
        $status->comment = $comment;
        $status->save();

        $status->refresh();

        return $status;
    }

    public function callResultLead(Request $request)
    {
        $contactId = $request->get('contact_id', 0);
        $comment = $request->get('comment', '');
        $contact = BaseRecord::findOrFail($contactId);
        $contact->status = BaseRecord::STATUS_LEAD;
        $contact->save();

        $status = new BaseRecordStatus();
        $status->project_id = $contact->project_id;
        $status->base_record_id = $contact->id;
        $status->employee_id = $contact->employee_id;
        $status->status = BaseRecordStatus::STATUS_LEAD;
        $status->comment = $comment;
        $status->save();

        $status->refresh();

        return $status;
    }

    public function callResultReject(Request $request)
    {
        $contactId = $request->get('contact_id', 0);
        $comment = $request->get('comment', '');
        $contact = BaseRecord::findOrFail($contactId);
        $contact->status = BaseRecord::STATUS_REJECT;
        $contact->save();

        $status = new BaseRecordStatus();
        $status->project_id = $contact->project_id;
        $status->base_record_id = $contact->id;
        $status->employee_id = $contact->employee_id;
        $status->status = BaseRecordStatus::STATUS_REJECT;
        $status->comment = $comment;
        $status->save();

        $status->refresh();

        return $status;
    }

    public function getCallResults(Request $request)
    {
        $projectId = $request->get('project_id', 0);
        $from = $request->get('from', now()->subMonth());
        $to = $request->get('to', now()->endOfDay());
        $employeeId = $request->get('employee_id', null);
        $statuses = $request->get('statuses', [
            BaseRecordStatus::STATUS_RECALL,
            BaseRecordStatus::STATUS_REJECT,
            BaseRecordStatus::STATUS_LEAD
        ]);

        $query = BaseRecordStatus::query();

        $query->where('project_id', $projectId);
        $query->where('created_at', '>=', $from);
        $query->where('created_at', '<=', $to);

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        $query->whereIn('status', $statuses);

        $query->with(['baseRecord']);

        return $query->get();
    }

    public function getContact(Request $request)
    {
        $contactId = $request->get('contact_id');

        return BaseRecord::findOrFail($contactId);
    }
}

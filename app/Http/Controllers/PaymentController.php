<?php

namespace App\Http\Controllers;

use App\Models\Contacts\BaseRecord;
use App\Models\NotificationText;
use App\Models\Payments\Invoice;
use App\Models\Projects\Project;
use App\Models\User;
use Illuminate\Http\Request;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\NotificationEventType;

class PaymentController extends Controller
{
    public function gateYoomoney(Request $request)
    {
        $requestBody = $request->all();

        try {
            $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
                ? new NotificationSucceeded($requestBody)
                : new NotificationWaitingForCapture($requestBody);

            \Log::debug(print_r($notification, 1));

            $id = $notification->object->getId();

            $invoice = Invoice::where('paysys_id', $id)->first();


            if (!$invoice) {
                \Log::error('NO INVOICE FOUND WITH ID', $id);
                return 'ok';
            }

            if ($invoice->for_rate) {
                $user = User::find($invoice->user_id);
                if ($user->active_to && ($user->active_to > now())) {
                    $user->active_to = $user->active_to->addMonth();
                } else {
                    $user->active_to = now()->addMonth();
                }
                $user->payment_status = 1;
                $user->save();

                NotificationText::notifiUser($user, NotificationText::EVENT_RATE_PAYED, []);

                foreach ($user->projects as $project) {
                    $contactsCount = BaseRecord::where('project_id', $project->id)
                        ->whereIn('status', [BaseRecord::STATUS_NEW, BaseRecord::STATUS_RECALL])
                        ->count();

                    if ($contactsCount && ($project->leads - $project->leads_created > 0)) {
                        $project->active_to = null;
                        $project->save();
                    }
                }
            }

            if ($invoice->for_leads || $invoice->for_contacts) {
                $project = Project::find($invoice->project_id);

                if ($invoice->for_leads) {
                    $project->leads += $invoice->for_leads;
                    $project->save();

                    NotificationText::notifiUser($user, NotificationText::EVENT_LEADS_PAYED, [
                        'project_name' => $project->company_name
                    ]);
                }

                if ($invoice->for_contacts) {
                    NotificationText::notifiUser($user, NotificationText::EVENT_LEADS_PAYED, [
                        'project_name' => $project->company_name
                    ]);
                }

                if (!$user->active_to || ($user->active_to > now())) {
                    $contactsCount = BaseRecord::where('project_id', $project->id)
                        ->whereIn('status', [BaseRecord::STATUS_NEW, BaseRecord::STATUS_RECALL])
                        ->count();

                    if ($contactsCount && ($project->leads - $project->leads_created > 0)) {
                        $project->active_to = null;
                        $project->save();
                    }
                }
            }

            $invoice->status = Invoice::STATUS_PAYED;
            $invoice->save();

            return 'ok';
        } catch (\Exception $e) {
            // Обработка ошибок при неверных данных
            \Log::error($e);
            abort(500);
        }
    }
}

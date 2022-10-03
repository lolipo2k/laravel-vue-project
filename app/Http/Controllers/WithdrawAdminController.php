<?php

namespace App\Http\Controllers;

use App\Models\NotificationText;
use App\Models\Payments\Withdraw;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class WithdrawAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function confirm(Request $request)
    {
        $w = Withdraw::find($request->get('withdrawId'));
        $w->status = Withdraw::STATUS_COMPLETE;
        $w->save();

        $user = User::find($w->employee_id);

        NotificationText::notifiUser($user, NotificationText::EVENT_WITHDRAW_CONFIRMED, ['amount' => $w->amount]);

        return "Запрос на выплату переведен в статус \"подтвержден\". Пожалуйста обновите список";
    }

    public function cancel(Request $request)
    {
        $w = Withdraw::find($request->get('withdrawId'));
        $w->status = Withdraw::STATUS_CANCELED;
        $w->save();

        User::where('id', $w->employee_id)->increment('balance', $w->amount);

        $user = User::find($w->employee_id);
        NotificationText::notifiUser($user, NotificationText::EVENT_WITHDRAW_CANCELED, ['amount' => $w->amount]);

        return "Запрос на выплату переведен в статус \"отменен\". Средства возвращены сотруднику. Пожалуйста обновите список";
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: don3d_000
 * Date: 13.09.2019
 * Time: 17:49
 */

namespace App\Notifications\Channels;


use App\Events\NewNotification;
use App\Jobs\DeliverTelegram;
use App\Models\TelegramHistory;
use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;


class CabinetChannel
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toArray($notifiable);
        $n = new \App\Models\Notification();
        $n->message = $data['text'];
        $n->title = $data['title'];
        $n->user_id = $notifiable->id;
        $n->save();

//        event(new NewNotification($notifiable));
    }
}

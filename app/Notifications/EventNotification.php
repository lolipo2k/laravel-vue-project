<?php

namespace App\Notifications;

use App\Models\NotificationText;
use App\Models\User;
use App\Notifications\Channels\CabinetChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventNotification extends Notification
{
    use Queueable;

    public $notificationText;
    public $params;

    /**
     * Create a new notification instance.
     *
     * @param NotificationText $text
     * @param $params
     */
    public function __construct(NotificationText $text, $params)
    {
        $this->notificationText = $text;
        $this->params = $params;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $target = [];

        if ($this->notificationText->to_cabinet) {
            $target[] = CabinetChannel::class;
        }

        if ($this->notificationText->to_email) {
            $target[] = 'email';
//            $target[] = CabinetChannel::class;
        }

        return $target;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->notificationText->title,
            'text' => $this->notificationText->formatText($this->params)
        ];
    }
}

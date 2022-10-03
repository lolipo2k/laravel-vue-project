<?php

namespace App\Models;

use App\Notifications\EventNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * App\Models\NotificationText
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $message
 * @property string|null $email
 * @property int $to_cabinet
 * @property int $to_email
 * @property string|null $alias
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationText newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationText newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationText query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationText whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationText whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationText whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationText whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationText whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationText whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationText whereToCabinet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationText whereToEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationText whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NotificationText extends Model
{
    protected $table = 'notification_text';

    public const EVENT_NEW_EMPLOYEE = 'EVENT_NEW_EMPLOYEE';
    public const EVENT_NEW_CLIENT = 'EVENT_NEW_CLIENT';
    public const EVENT_INVOICE_ATTACHED = 'EVENT_INVOICE_ATTACHED';
    public const EVENT_PROJECT_MODERATED = 'EVENT_PROJECT_MODERATED';
    public const EVENT_NEW_LEAD = 'EVENT_NEW_LEAD';
    public const EVENT_RATE_ENDING = 'EVENT_RATE_ENDING';
    public const EVENT_EMPLOYEE_ACCEPTED = 'EVENT_EMPLOYEE_ACCEPTED';
    public const EVENT_LEAD_CONFIRMED = 'EVENT_LEAD_CONFIRMED';
    public const EVENT_ADMIN_NEW_USER = 'EVENT_ADMIN_NEW_USER';
    public const EVENT_ADMIN_NEW_PROJECT = 'EVENT_ADMIN_NEW_PROJECT';
    public const EVENT_ADMIN_INVOICE_PAYED = 'EVENT_ADMIN_INVOICE_PAYED';
    public const EVENT_ADMIN_NEW_PROJECT_REQUEST = 'EVENT_ADMIN_NEW_PROJECT_REQUEST';
    public const EVENT_ADMIN_NEW_LEAD = 'EVENT_ADMIN_NEW_LEAD';
    public const EVENT_ADMIN_LEADS_ENDING = 'EVENT_ADMIN_LEADS_ENDING';
    public const EVENT_ADMIN_CONTACTS_ENDING = 'EVENT_ADMIN_CONTACTS_ENDING';
    public const EVENT_ADMIN_RATE_ENDING = 'EVENT_ADMIN_RATE_ENDING';
    public const EVENT_ADMIN_NEW_WITHDRAW = 'EVENT_ADMIN_NEW_WITHDRAW';
    public const EVENT_WITHDRAW_CONFIRMED = 'EVENT_WITHDRAW_CONFIRMED';
    public const EVENT_WITHDRAW_CANCELED = 'EVENT_WITHDRAW_CANCELED';
    public const EVENT_RATE_PAYED = 'EVENT_RATE_PAYED';
    public const EVENT_CONTACTS_PAYED = 'EVENT_CONTACTS_PAYED';
    public const EVENT_LEADS_PAYED = 'EVENT_LEADS_PAYED';

    public const EVENT_NAMES = [
        self::EVENT_NEW_EMPLOYEE => 'EVENT_NEW_EMPLOYEE',
        self::EVENT_NEW_CLIENT => 'EVENT_NEW_CLIENT',
        self::EVENT_INVOICE_ATTACHED => 'EVENT_INVOICE_ATTACHED',
        self::EVENT_PROJECT_MODERATED => 'EVENT_PROJECT_MODERATED',
        self::EVENT_NEW_LEAD => 'EVENT_NEW_LEAD',
        self::EVENT_RATE_ENDING => 'EVENT_RATE_ENDING',
        self::EVENT_EMPLOYEE_ACCEPTED => 'EVENT_EMPLOYEE_ACCEPTED',
        self::EVENT_LEAD_CONFIRMED => 'EVENT_LEAD_CONFIRMED',
        self::EVENT_ADMIN_NEW_USER => 'EVENT_ADMIN_NEW_USER',
        self::EVENT_ADMIN_NEW_PROJECT => 'EVENT_ADMIN_NEW_PROJECT',
        self::EVENT_ADMIN_INVOICE_PAYED => 'EVENT_ADMIN_INVOICE_PAYED',
        self::EVENT_ADMIN_NEW_PROJECT_REQUEST => 'EVENT_ADMIN_NEW_PROJECT_REQUEST',
        self::EVENT_ADMIN_NEW_LEAD => 'EVENT_ADMIN_NEW_LEAD',
        self::EVENT_ADMIN_LEADS_ENDING => 'EVENT_ADMIN_LEADS_ENDING',
        self::EVENT_ADMIN_CONTACTS_ENDING => 'EVENT_ADMIN_CONTACTS_ENDING',
        self::EVENT_ADMIN_RATE_ENDING => 'EVENT_ADMIN_RATE_ENDING',
        self::EVENT_ADMIN_NEW_WITHDRAW => 'EVENT_ADMIN_NEW_WITHDRAW',
        self::EVENT_WITHDRAW_CONFIRMED => 'EVENT_WITHDRAW_CONFIRMED',
        self::EVENT_WITHDRAW_CANCELED => 'EVENT_WITHDRAW_CANCELED',
        self::EVENT_RATE_PAYED => 'EVENT_RATE_PAYED',
        self::EVENT_CONTACTS_PAYED => 'EVENT_CONTACTS_PAYED',
        self::EVENT_LEADS_PAYED => 'EVENT_LEADS_PAYED',
    ];

    public function formatText($params)
    {
        $replace = array_values($params);
        $search = array_map(static function ($item) {
            return ':' . $item;
        }, array_keys($params));

        return str_replace($search, $replace, $this->message);
    }

    /**
     * Returns EventNotification for current message text
     *
     * @param $name
     * @param $params
     * @return EventNotification|null
     */
    public static function getEvent($name, $params): ?EventNotification
    {
        $text = self::where('alias', $name)->first();

        if (!$text) {
            return null;
        }

        return new EventNotification($text, $params);
    }

    public static function notifiUser($user, $eventName, $params)
    {
        $event = self::getEvent($eventName, $params);
        if ($event) {
            $user->notify($event);
        }
    }
}

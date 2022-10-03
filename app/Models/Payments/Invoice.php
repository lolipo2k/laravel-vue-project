<?php

namespace App\Models\Payments;

use App\Models\Projects\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Payments\Invoice
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payments\Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payments\Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payments\Invoice query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property int|null $project_id
 * @property float $amount
 * @property int $type
 * @property int $status
 * @property string|null $invoice
 * @property string|null $check
 * @property string|null $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payments\Invoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payments\Invoice whereCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payments\Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payments\Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payments\Invoice whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payments\Invoice whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payments\Invoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payments\Invoice whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payments\Invoice whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payments\Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payments\Invoice whereUserId($value)
 * @property-read mixed $status_text
 * @property-read mixed $type_text
 * @property-read \App\Models\Projects\Project|null $project
 * @property-read \App\Models\User $user
 * @property string|null $paysys_id
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice wherePaysysId($value)
 * @property int $for_rate
 * @property int $for_leads
 * @property int $for_contacts
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereForContacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereForLeads($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereForRate($value)
 */
class Invoice extends Model
{
    protected $table = 'invoices';

    public const PAYMENT_TYPE_NOT_SPECIFIED = 0;
    public const PAYMENT_TYPE_ONLINE = 1;
    public const PAYMENT_TYPE_BY_INVOICE = 2;

    public const PAYMENT_TYPE_NAMES = [
        self::PAYMENT_TYPE_NOT_SPECIFIED => 'Не указан',
        self::PAYMENT_TYPE_ONLINE => 'Оплата онлайн',
        self::PAYMENT_TYPE_BY_INVOICE => 'Оплата по счету',
    ];

    public const STATUS_NEW = 0;
    public const STATUS_INVOICE_PENDING = 1;
    public const STATUS_PAYED = 2;
    public const STATUS_EXPIRED = 3;
    public const STATUS_CANCELED_BY_USER = 4;
    public const STATUS_CANCELED_BY_COMPANY = 5;
    public const STATUS_PENDING = 6;

    public const STATUS_NAMES = [
        self::STATUS_NEW => 'Новый',
        self::STATUS_INVOICE_PENDING => 'Ожидает выставления счета',
        self::STATUS_PAYED => 'Оплачен',
        self::STATUS_EXPIRED => 'Истекло время оплаты',
        self::STATUS_CANCELED_BY_USER => 'Отменен пользователем',
        self::STATUS_CANCELED_BY_COMPANY => 'Отменен компанией',
        self::STATUS_PENDING => 'Ожидает оплаты',
    ];


    protected $appends = [
        'statusText',
        'typeText'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function getStatusTextAttribute()
    {
        return self::STATUS_NAMES[$this->status];
    }

    public function getTypeTextAttribute()
    {
        return self::PAYMENT_TYPE_NAMES[$this->type];
    }
}

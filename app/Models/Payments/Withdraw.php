<?php

namespace App\Models\Payments;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Payments\Withdraw
 *
 * @property int $id
 * @property int $employee_id
 * @property float $amount
 * @property int $status
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw query()
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read User $employee
 */
class Withdraw extends Model
{

    public const STATUS_NEW = 0;
    public const STATUS_COMPLETE = 1;
    public const STATUS_CANCELED = 2;

    public const STATUS_NAMES = [
        self::STATUS_NEW => 'новый',
        self::STATUS_COMPLETE => 'подтвержден',
        self::STATUS_CANCELED => 'отклонен',
    ];

    protected $table = 'withdraw';

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}

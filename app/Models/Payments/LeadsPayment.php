<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Payments\LeadsPayment
 *
 * @property int $id
 * @property int $user_id
 * @property int $project_id
 * @property int $lead_id
 * @property float $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LeadsPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadsPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadsPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadsPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadsPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadsPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadsPayment whereLeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadsPayment whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadsPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadsPayment whereUserId($value)
 * @mixin \Eloquent
 * @property int $percent
 * @method static \Illuminate\Database\Eloquent\Builder|LeadsPayment wherePercent($value)
 */
class LeadsPayment extends Model
{
    protected $table = 'leads_payments';
}

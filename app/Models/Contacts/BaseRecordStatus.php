<?php

namespace App\Models\Contacts;

use App\Models\Payments\LeadsPayment;
use App\Models\Projects\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contacts\BaseRecordStatus
 *
 * @property int $id
 * @property int $base_record_id
 * @property int $status
 * @property string|null $commant
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecordStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecordStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecordStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecordStatus whereBaseRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecordStatus whereCommant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecordStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecordStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecordStatus whereNextDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecordStatus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecordStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $project_id
 * @property int|null $employee_id
 * @property string|null $comment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecordStatus whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecordStatus whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecordStatus whereProjectId($value)
 * @property \Illuminate\Support\Carbon|null $next_date
 * @property int $confirmed
 * @property int $freezed
 * @property-read \App\Models\Contacts\BaseRecord $baseRecord
 * @method static \Illuminate\Database\Eloquent\Builder|BaseRecordStatus whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseRecordStatus whereFreezed($value)
 * @property-read User|null $employee
 * @property-read Project $project
 */
class BaseRecordStatus extends Model
{
    protected $table = 'base_record_status';

    public const STATUS_RECALL = 0;
    public const STATUS_REJECT = 1;
    public const STATUS_LEAD = 2;

    public const STATUS_NAMES = [
        self::STATUS_RECALL => 'перезвон',
        self::STATUS_REJECT => 'отказ',
        self::STATUS_LEAD => 'лид',
    ];

    protected $dates = [
        'next_date'
    ];

    public function baseRecord()
    {
        return $this->belongsTo(BaseRecord::class, 'base_record_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function payForLead()
    {
        $this->confirmed = true;
        $user = User::find($this->employee_id);
        $project = Project::find($this->project_id);

        $payment = new LeadsPayment();
        $payment->user_id = $user->id;
        $payment->project_id = $project->id;
        $percent = $user->own ? config('payments.own_percent') : config('payments.not_own_percent');
        $payment->percent = $percent;
        $payment->amount = round($project->lead_price / 100 * $percent, 2);
        $payment->save();
        $this->save();
        User::where('id', $user->id)->increment('balance', $payment->amount);
        Project::where('id', $project->id)->increment('leads_created', 1);
    }
}

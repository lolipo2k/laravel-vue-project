<?php

namespace App\Models\Contacts;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contacts\BaseRecord
 *
 * @property int $id
 * @property int $user_id
 * @property int $project_id
 * @property string|null $phones
 * @property string|null $names
 * @property string|null $info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord whereNames($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord wherePhones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $employee_id
 * @property string|null $company
 * @property int $status
 * @property string|null $history
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord byEmplyeeId($employeeId)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord byProjectId($projectId)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord whereHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\BaseRecord whereStatus($value)
 */
class BaseRecord extends Model
{
    protected $table = 'base_record';

    public const STATUS_NEW = 0;
    public const STATUS_RECALL = 1;
    public const STATUS_REJECT = 2;
    public const STATUS_LEAD = 3;

    public const STATUS_NAMES = [
        self::STATUS_NEW => 'новый',
        self::STATUS_RECALL => 'перезвон',
        self::STATUS_REJECT => 'отказ',
        self::STATUS_LEAD => 'лид',
    ];

    public function scopeByProjectId($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeByEmplyeeId($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

}

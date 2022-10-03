<?php

namespace App\Models\Projects;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\Projects\ProjectUser
 *
 * @property int $project_id
 * @property int $user_id
 * @property string|null $taken_at
 * @property int $status
 * @property int $status_viewed
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectUser whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectUser whereStatusViewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectUser whereTakenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectUser whereUserId($value)
 * @mixin \Eloquent
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectUser whereId($value)
 * @property-read \App\Models\Projects\Project $project
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectUser isNew()
 */
class ProjectUser extends Pivot
{
    protected $table = 'project_user';
    public $timestamps = false;
    public $incrementing = true;

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeIsNew($q)
    {
        return $q->where('status', Project::STATUS_NEW);
    }
}

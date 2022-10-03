<?php

namespace App\Models\Projects;

use App\Models\Projects\Project;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Projects\ProjectContact
 *
 * @property int $id
 * @property int $project_id
 * @property string|null $phone
 * @property string|null $name
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Projects\Project $project
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectContact query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectContact whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectContact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectContact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectContact whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectContact whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectContact extends Model
{
    protected $table = 'project_contacts';

    protected $fillable = [
        'project_id',
        'phone',
        'name',
        'comment',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}

<?php

namespace App\Models\Projects;

use App\Models\Contacts\ContactPerson;
use App\Models\Projects\ProjectCallPerson;
use App\Models\Taxonomy\Field;
use App\Models\Taxonomy\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Projects\ProjectCallContact
 *
 * @property int $id
 * @property int $project_id
 * @property string|null $company_name
 * @property int $region_id
 * @property int $field_id
 * @property string|null $site
 * @property string|null $comment
 * @property int $status
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Taxonomy\Field $field
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Projects\ProjectCallPerson[] $persons
 * @property-read int|null $persons_count
 * @property-read \App\Models\Taxonomy\Region $region
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallContact query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallContact whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallContact whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallContact whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallContact whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallContact whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallContact whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallContact whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallContact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallContact whereUserId($value)
 * @mixin \Eloquent
 */
class ProjectCallContact extends Model
{
    protected $table = 'project_call_contacts';

    public function persons()
    {
        return $this->hasMany(ProjectCallPerson::class, 'project_call_contact_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}

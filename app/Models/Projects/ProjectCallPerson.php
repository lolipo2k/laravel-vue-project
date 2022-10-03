<?php

namespace App\Models\Projects;

use App\Models\Contacts\ContactPerson;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Projects\ProjectCallPerson
 *
 * @property int $id
 * @property int $project_id
 * @property int $project_call_contact_id
 * @property int|null $contact_person_id
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $name
 * @property string|null $position
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Projects\ProjectCallContact $contact
 * @property-read \App\Models\Contacts\ContactPerson|null $originalPerson
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallPerson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallPerson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallPerson query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallPerson whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallPerson whereContactPersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallPerson whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallPerson whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallPerson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallPerson whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallPerson wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallPerson wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallPerson whereProjectCallContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallPerson whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ProjectCallPerson whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectCallPerson extends Model
{
    protected $table = 'project_call_persons';

    public function contact()
    {
        return $this->belongsTo(ProjectCallContact::class, 'project_call_contact_id');
    }

    public function originalPerson()
    {
        return $this->belongsTo(ContactPerson::class, 'contact_person_id');
    }
}

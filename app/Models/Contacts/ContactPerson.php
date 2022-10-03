<?php

namespace App\Models\Contacts;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contacts\ContactPerson
 *
 * @property int $id
 * @property int $contact_id
 * @property int $status
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $name
 * @property string|null $position
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contacts\Contact $contact
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\ContactPerson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\ContactPerson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\ContactPerson query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\ContactPerson whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\ContactPerson whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\ContactPerson whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\ContactPerson whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\ContactPerson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\ContactPerson whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\ContactPerson wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\ContactPerson wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\ContactPerson whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\ContactPerson whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactPerson extends Model
{
    protected $table = 'contact_persons';

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}

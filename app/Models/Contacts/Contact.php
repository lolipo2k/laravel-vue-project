<?php

namespace App\Models\Contacts;

use App\Models\Taxonomy\Field;
use App\Models\Taxonomy\Region;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contacts\Contact
 *
 * @property int $id
 * @property string|null $company_name
 * @property int $region_id
 * @property int $field_id
 * @property string|null $site
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contacts\ContactPerson[] $persons
 * @property-read int|null $persons_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\Contact whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\Contact whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\Contact whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\Contact whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\Contact whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contacts\Contact whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Taxonomy\Field $field
 * @property-read \App\Models\Taxonomy\Region $region
 */
class Contact extends Model
{
    protected $table = 'contacts';

    public function persons()
    {
        return $this->hasMany(ContactPerson::class, 'contact_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}

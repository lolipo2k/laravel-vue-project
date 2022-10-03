<?php

namespace App\Models\Projects;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Projects\ContactStatus
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ContactStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ContactStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ContactStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ContactStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ContactStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ContactStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ContactStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactStatus extends Model
{
    protected $table = 'contact_statuses';
}

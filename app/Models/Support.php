<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Support
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Support newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Support newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Support query()
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $email
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $text
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Support whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Support whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Support whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Support whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Support wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Support whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Support whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Support whereUserId($value)
 * @property-read \App\Models\User|null $user
 */
class Support extends Model
{
    protected $table = 'support';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

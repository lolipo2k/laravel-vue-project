<?php

namespace App\Models\Taxonomy;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Taxonomy\WorkExperience
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\WorkExperience newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\WorkExperience newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\WorkExperience query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\WorkExperience whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\WorkExperience whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\WorkExperience whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\WorkExperience whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WorkExperience extends Model
{
    protected $table = 'work_experience';
}

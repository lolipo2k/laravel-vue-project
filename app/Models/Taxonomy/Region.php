<?php

namespace App\Models\Taxonomy;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Taxonomy\Region
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Region whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $region_category_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Region whereRegionCategoryId($value)
 */
class Region extends Model
{
    protected $table = 'regions';
}

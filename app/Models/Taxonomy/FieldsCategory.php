<?php

namespace App\Models\Taxonomy;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Taxonomy\RegionCategories
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\FieldsCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\FieldsCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\FieldsCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\FieldsCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\FieldsCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\FieldsCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\FieldsCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Taxonomy\Field[] $fields
 * @property-read int|null $fields_count
 */
class FieldsCategory extends Model
{
    protected $table = 'field_categories';

    protected $fillable = ['name'];

    public function fields()
    {
        return $this->hasMany(Field::class, 'field_category_id');
    }
}

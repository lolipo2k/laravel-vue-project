<?php

namespace App\Models\Taxonomy;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Taxonomy\Field
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Field newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Field newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Field query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Field whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Field whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Field whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Field whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property float $price
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Field wherePrice($value)
 * @property int|null $field_category_id
 * @property-read \App\Models\Taxonomy\FieldsCategory|null $category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\Field whereFieldCategoryId($value)
 */
class Field extends Model
{
    protected $table = 'fields';

    protected $fillable = [
        'name', 'price'
    ];

    public function category()
    {
        return $this->belongsTo(FieldsCategory::class, 'field_category_id');
    }
}

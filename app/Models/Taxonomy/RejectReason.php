<?php

namespace App\Models\Taxonomy;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Taxonomy\RejectReason
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\RejectReason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\RejectReason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\RejectReason query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\RejectReason whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\RejectReason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\RejectReason whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Taxonomy\RejectReason whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RejectReason extends Model
{
    protected $table = 'reject_reasons';
}

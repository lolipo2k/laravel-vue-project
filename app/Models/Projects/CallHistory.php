<?php

namespace App\Models\Projects;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Projects\CallHistory
 *
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 * @property int $status
 * @property int|null $related_call_history_id
 * @property int $project_call_contact_id
 * @property string|null $comment
 * @property string|null $planned_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\CallHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\CallHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\CallHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\CallHistory whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\CallHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\CallHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\CallHistory wherePlannedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\CallHistory whereProjectCallContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\CallHistory whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\CallHistory whereRelatedCallHistoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\CallHistory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\CallHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\CallHistory whereUserId($value)
 * @mixin \Eloquent
 */
class CallHistory extends Model
{
    protected $table = 'call_history';
}

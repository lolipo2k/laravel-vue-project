<?php

namespace App\Models\Projects;

use App\Models\Contacts\BaseRecord;
use App\Models\Taxonomy\Field;
use App\Models\Taxonomy\Region;
use App\Models\Taxonomy\RejectReason;
use App\Models\User;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Projects\Project
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $field_id
 * @property int $b2b
 * @property string $company_name
 * @property string $site_url
 * @property string|null $address
 * @property string|null $ceo_name
 * @property string|null $target
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereB2b($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereCeoName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereSiteUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $description
 * @property string|null $closed_at
 * @property float $lead_price
 * @property-read \App\Models\Taxonomy\Field|null $field
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Taxonomy\Region[] $regions
 * @property-read int|null $regions_count
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $viewers
 * @property-read int|null $viewers_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereClosedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereLeadPrice($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Projects\ProjectContact[] $contacts
 * @property-read int|null $contacts_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project notArchived()
 * @property string|null $script
 * @property array|null $criteries
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereCriteries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereScript($value)
 * @property float $criterion_price
 * @property int $criterion_month
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereCriterionMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereCriterionPrice($value)
 * @property string|null $real_address
 * @property string|null $ceo_fio
 * @property string|null $seo_position
 * @property string|null $seo_email
 * @property string|null $seo_phone
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereCeoFio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereRealAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereSeoEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereSeoPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereSeoPosition($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Taxonomy\Region[] $priorityRegions
 * @property-read int|null $priority_regions_count
 * @property string|null $legal_address
 * @property string|null $board
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereBoard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereLegalAddress($value)
 * @property string|null $legal_name
 * @property int $leads
 * @property int $make_script
 * @property int $make_base
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereLeads($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereLegalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereMakeBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereMakeScript($value)
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereStatus($value)
 * @property int $leads_created
 * @property string|null $active_to
 * @property string|null $payed_to
 * @property string|null $comment
 * @property int|null $reject_reason_id
 * @property string|null $inn
 * @property string|null $kpp
 * @property-read \App\Models\Taxonomy\RejectReason|null $rejectReason
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereActiveTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereKpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereLeadsCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project wherePayedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project whereRejectReasonId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contacts\BaseRecord[] $baseRecords
 * @property-read int|null $base_records_count
 * @property string|null $file
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereFile($value)
 * @property string|null $criterion_position
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCriterionPosition($value)
 */
class Project extends Model
{
    protected $table = 'projects';

    protected $casts = [
        'criteries' => 'json'
    ];

    public const STATUS_NEW = 0;
    public const STATUS_MODERATED = 1;
    public const STATUS_REJECTED = 2;

    public const STATUS_NAMES = [
        self::STATUS_NEW => 'Новый',
        self::STATUS_MODERATED => 'Одобрен модератором',
        self::STATUS_REJECTED => 'Отклонен модератором'
    ];

    public const LEAD_CRITERION_1 = 1;
    public const LEAD_CRITERION_2 = 2;
    public const LEAD_CRITERION_3 = 3;
    public const LEAD_CRITERION_4 = 4;
    public const LEAD_CRITERION_5 = 5;

    public const LEAD_CRITERION_NAMES = [
        self::LEAD_CRITERION_1 => 'контактное лицо принимает решение/влияет на принятие решения по обозначенной вами зоне ответственности',
        self::LEAD_CRITERION_2 => 'контактное лицо понимает суть вашего предложения',
        self::LEAD_CRITERION_3 => 'контактное лицо готово к контакту с вашим специалистом не позднее чем в течение 7 календарных дней с момента контакта оператора',
        self::LEAD_CRITERION_4 => 'контактное лицо подтвердило наличие минимального бюджета _______ руб. и отсутствие ограничений к заключению договора в перспективе ближайших _______ месяцев',
        self::LEAD_CRITERION_5 => 'контактное лицо занимает одну из перечисленных должностей: _______.',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class,
            'project_region',
            'project_id',
            'region_id');
    }

    public function priorityRegions()
    {
        return $this->belongsToMany(Region::class,
            'project_region_priority',
            'project_id',
            'region_id'
        );
    }

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id')
            ->using(ProjectUser::class)
            ->withPivot(['taken_at', 'status', 'status_viewed', 'project_id', 'user_id']);
    }

    public function viewers()
    {
        return $this->belongsToMany(User::class,
            'projects_2_user',
            'projects_id');
    }

    public function contacts()
    {
        return $this->hasMany(ProjectContact::class, 'project_id');
    }

    /**
     * @param QueryBuilder $query
     * @return mixed
     */
    public function scopeNotArchived($query)
    {
        return $query->whereNull('closed_at');
    }

    public function rejectReason()
    {
        return $this->belongsTo(RejectReason::class, 'reject_reason_id');
    }

    public function baseRecords()
    {
        return $this->hasMany(BaseRecord::class, 'project_id');
    }
}

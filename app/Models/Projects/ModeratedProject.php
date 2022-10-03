<?php


namespace App\Models\Projects;


/**
 * App\Models\Projects\ModeratedProject
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
 * @property string|null $description
 * @property string|null $closed_at
 * @property float $lead_price
 * @property string|null $script
 * @property array|null $criteries
 * @property float $criterion_price
 * @property int $criterion_month
 * @property string|null $real_address
 * @property string|null $ceo_fio
 * @property string|null $seo_position
 * @property string|null $seo_email
 * @property string|null $seo_phone
 * @property string|null $legal_address
 * @property string|null $legal_name
 * @property string|null $board
 * @property int $leads
 * @property int $make_script
 * @property int $make_base
 * @property int $status
 * @property int $leads_created
 * @property string|null $active_to
 * @property string|null $payed_to
 * @property string|null $comment
 * @property int|null $reject_reason_id
 * @property string|null $inn
 * @property string|null $kpp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Projects\ProjectContact[] $contacts
 * @property-read int|null $contacts_count
 * @property-read \App\Models\Taxonomy\Field|null $field
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Taxonomy\Region[] $priorityRegions
 * @property-read int|null $priority_regions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Taxonomy\Region[] $regions
 * @property-read int|null $regions_count
 * @property-read \App\Models\Taxonomy\RejectReason|null $rejectReason
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $viewers
 * @property-read int|null $viewers_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\Project notArchived()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject onlyNew()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereActiveTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereB2b($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereBoard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereCeoFio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereCeoName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereClosedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereCriteries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereCriterionMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereCriterionPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereKpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereLeadPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereLeads($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereLeadsCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereLegalAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereLegalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereMakeBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereMakeScript($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject wherePayedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereRealAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereRejectReasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereScript($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereSeoEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereSeoPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereSeoPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereSiteUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Projects\ModeratedProject whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contacts\BaseRecord[] $baseRecords
 * @property-read int|null $base_records_count
 * @property string|null $file
 * @method static \Illuminate\Database\Eloquent\Builder|ModeratedProject whereFile($value)
 * @property string|null $criterion_position
 * @method static \Illuminate\Database\Eloquent\Builder|ModeratedProject whereCriterionPosition($value)
 */
class ModeratedProject extends Project
{
    protected $table = 'projects';

    public function newQuery()
    {
        return parent::newQuery()
            ->where('status', '=', self::STATUS_NEW);
    }

    public function scopeOnlyNew($q)
    {
        return $q->where('status', self::STATUS_NEW);
    }
}
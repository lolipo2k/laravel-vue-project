<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $phone
 * @property string|null $last_name
 * @property string|null $avatar
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Projects\Project[] $projects
 * @property-read int|null $projects_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin admins()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User notAdmin()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin newQuery()
 * @property string|null $description
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Taxonomy\Field[] $fields
 * @property-read int|null $fields_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Taxonomy\WorkExperience[] $workExperience
 * @property-read int|null $work_experience_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereDescription($value)
 * @property int|null $region_id
 * @property-read \App\Models\Taxonomy\Region|null $region
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereRegionId($value)
 * @property int|null $moderator_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Taxonomy\FieldsCategory[] $fieldCategories
 * @property-read int|null $field_categories_count
 * @property-read \App\Models\User|null $moderator
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereModeratorId($value)
 * @property int $phone_confirmed
 * @property int $own
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereOwn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin wherePhoneConfirmed($value)
 * @property int $payment_status
 * @property string|null $active_to
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereActiveTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin wherePaymentStatus($value)
 * @property int $learned
 * @property float $balance
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereLearned($value)
 */
class Admin extends User
{
    protected $table = 'users';

    public function newQuery()
    {
        return parent::newQuery()
            ->where('role', '=', User::ROLE_ADMIN);
    }

    public function scopeAdmins($q)
    {
        return $q->where('role', User::ROLE_ADMIN);
    }
}

<?php

namespace App\Models;

use App\Models\Projects\Project;
use App\Models\Projects\ProjectUser;
use App\Models\Taxonomy\Field;
use App\Models\Taxonomy\FieldsCategory;
use App\Models\Taxonomy\Region;
use App\Models\Taxonomy\WorkExperience;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\User
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
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $phone
 * @property string|null $last_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @property string|null $avatar
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Projects\Project[] $projects
 * @property-read int|null $projects_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User notAdmin()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 * @property string|null $description
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Taxonomy\Field[] $fields
 * @property-read int|null $fields_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Taxonomy\WorkExperience[] $workExperience
 * @property-read int|null $work_experience_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDescription($value)
 * @property int|null $region_id
 * @property-read \App\Models\Taxonomy\Region|null $region
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRegionId($value)
 * @property int|null $moderator_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Taxonomy\FieldsCategory[] $fieldCategories
 * @property-read int|null $field_categories_count
 * @property-read \App\Models\User|null $moderator
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereModeratorId($value)
 * @property int $phone_confirmed
 * @property int $own
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOwn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhoneConfirmed($value)
 * @property int $payment_status
 * @property string|null $active_to
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereActiveTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePaymentStatus($value)
 * @property int $learned
 * @property float $balance
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLearned($value)
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public const ROLE_CLIENT = 'client';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_EMPLOYEE = 'employee';
    public const ROLE_MODERATOR = 'moderator';

    public const ROLE_NAMES = [
        self::ROLE_CLIENT => 'Клиент',
        self::ROLE_ADMIN => 'Администратор',
        self::ROLE_EMPLOYEE => 'Сотрудник',
        self::ROLE_MODERATOR => 'Модератор',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
        'last_name', 'avatar', 'description',
        'exp', 'phone'
    ];

    protected $dates = [
        'active_to'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'exp' => 'array'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function isAdmin()
    {
        return $this->role == self::ROLE_ADMIN;
    }

    public function scopeNotAdmin($q)
    {
        return $q->where('role', '<>', User::ROLE_ADMIN);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user')
            ->using(ProjectUser::class)
            ->withPivot(['taken_at', 'status', 'status_viewed']);
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class, 'field_user');
    }

    public function fieldCategories()
    {
        return $this->belongsToMany(FieldsCategory::class,
            'field_category_user',
            'user_id',
            'field_category_id');
    }

    public function workExperience()
    {
        return $this->belongsToMany(WorkExperience::class,
            'user_work_experience',
            'user_id',
            'work_experience_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }
}

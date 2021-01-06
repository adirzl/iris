<?php

namespace Modules\User\Entities;

use App\Concerns\TapActivity;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use CanResetPassword, HasRoles, Notifiable, TapActivity;

    /**
     * @var string
     */
    protected $table = 'app_user';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'email', 'status',
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
    ];

    /**
     * @var string
     */
    protected $guard_name = 'web';

    /**
     * @var bool
     */
    protected static $logFillable = true;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
        });
    }

    /**
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return get_class() . ' ' . json_encode($this->attributesToArray()) . ' ' . $eventName . '.';
    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFindByUsername($query, $value)
    {
        return $query->where('username', $value)->first();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFindByRoleId($query, $value)
    {
        return $query->select(['app_user.*', 'app_profile.*'])
            ->join('app_profile', 'app_user.id', '=', 'app_profile.user_id')
            ->join('mst_model_has_role', 'app_user.id', '=', 'mst_model_has_role.model_uuid')
            ->where('mst_model_has_role.role_id', $value)->first();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $roleId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFindRolesById($query, $roleId)
    {
        $result = $query->select(['app_user.*', 'app_profile.*'])
            ->join('app_profile', 'app_user.id', '=', 'app_profile.user_id')
            ->join('mst_model_has_role', 'app_user.id', '=', 'mst_model_has_role.model_uuid')
            ->where('mst_model_has_role.role_id', $roleId)
            ->get();
    }
}

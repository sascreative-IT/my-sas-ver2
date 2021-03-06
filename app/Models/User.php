<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected $auditExclude = [
        'password',
    ];


    public const ROLE_ADMINISTRATOR = 'Administrator';
    public const ROLE_CUSTOMER_SERVICE_AGENT = 'Customer Service Agent';
    public const ROLE_SALES_AGENT = 'Sales Agent';
    public const ROLE_PRODUCTION_MANAGER = 'Production Manager';
    public const ROLE_PURCHASING_OFFICER = 'Purchasing Officer';


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function csCustomers()
    {
        return $this->hasMany(Customer::class, 'cs_agent_id');
    }

    public function salesCustomers()
    {
        return $this->hasMany(Customer::class, 'sales_agent_id');
    }

    public function erpUserDetails() : HasOne
    {
        return $this->hasOne(ErpUserDetail::class, 'user_id');
    }

    public function factories(): BelongsToMany
    {
        return $this->belongsToMany(Factory::class, 'user_factory');
    }
}

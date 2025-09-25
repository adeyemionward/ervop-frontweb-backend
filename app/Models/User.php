<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enum\BusinessType;
use App\Enum\UserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'business_type',
        'business_name',
        'business_industry',
        'ervop_url',
        'website',
        'email',
        'phone',
        'password', // It is safe to add 'password' as it's hashed before saving.
        'last_login_at',
        'last_login_ip',
        'user_type',
        'status',
        'business_logo',
        'address',
        'city',
        'state',
        'verification_token',
        'verification_token_expires_at',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $casts = [
        'status' => UserStatus::class,
        'business_type' => BusinessType::class,
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    /**
     * Get the date overrides (unavailable dates) for the user.
     */
    public function dateOverrides()
    {
        return $this->hasMany(DateOverride::class);
    }

    /**
     * Get the appointments booked with this user (as the professional).
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}

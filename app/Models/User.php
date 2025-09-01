<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
        'token_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'token_expires_at' => 'datetime',
    ];

    /**
     * Check if the user's API token is expired
     */
    public function isTokenExpired(): bool
    {
        return $this->token_expires_at && $this->token_expires_at->isPast();
    }

    /**
     * Check if the user has a valid API token
     */
    public function hasValidToken(): bool
    {
        return $this->api_token && !$this->isTokenExpired();
    }

    /**
     * Clear the user's API token
     */
    public function clearToken(): void
    {
        $this->update([
            'api_token' => null,
            'token_expires_at' => null,
        ]);
    }

    /**
     * Get user's roles (if you're using a role system)
     */
    public function roles()
    {
        // If you have a roles relationship, uncomment and modify as needed
        // return $this->belongsToMany(Role::class);
        return [];
    }

    /**
     * Get user's permissions (if you're using a permission system)
     */
    public function permissions()
    {
        // If you have a permissions relationship, uncomment and modify as needed
        // return $this->hasManyThrough(Permission::class, Role::class);
        return [];
    }

    /**
     * Get user roles as array for API responses
     */
    public function getRolesAttribute()
    {
        // If you have roles, return them as array
        // return $this->roles()->pluck('name')->toArray();
        return [];
    }

    /**
     * Get user permissions as array for API responses
     */
    public function getPermissionsAttribute()
    {
        // If you have permissions, return them as array
        // return $this->permissions()->pluck('name')->toArray();
        return [];
    }
}

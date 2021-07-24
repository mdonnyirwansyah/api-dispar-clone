<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'slug'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function newsPostsAuthor()
    {
        return $this->hasMany(NewsPost::class, 'author_id');
    }

    public function newsPostsEditor()
    {
        return $this->hasMany(NewsPost::class, 'editor_id');
    }

    /**
     * Check if the user has a role
     * @param string $role
     * @return bool
     */
    public function hasAnyRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }

    /**
     * Check the user has any given role
     * @param array $role
     * @return bool
     */
    public function hasAnyRoles($role)
    {
        return null !== $this->roles()->whereIn('name', $role)->first();
    }
}

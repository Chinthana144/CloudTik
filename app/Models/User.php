<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //has many camp users
    public function campusers()
    {
        return $this->hasMany(campusers::class, 'user_id');
    }

    public function counter()
    {
        return $this->hasMany(Counter::class, 'user_id');
    }

    public function subscription()
    {
        return $this->hasMany(Subscriptions::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    public function hasPageAccess($page_id)
    {
        //
        return RolePages::where('role_id', $this->role_id)
            ->where('page_id', $page_id)
            ->where('permissions', 1)
            ->exists();
    }
}

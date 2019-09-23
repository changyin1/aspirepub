<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'status', 'languages', 'city', 'country', 'grandfathered'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'languages' => 'array',
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    public function availabilities()
    {
        return $this->hasMany('App\Availability');
    }

    public function hasRole($role)
    {
        if ($role == 'call_specialist' || $role == 'coach') {
            return (User::where('role', $role)->orWhere('role', 'specialist_and_coach')->get());
        }
        return User::where('role', $role)->get();
    }
}

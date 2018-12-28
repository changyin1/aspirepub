<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	protected $fillable = [
        'name', 'city', 'country'
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function calls()
    {
        return $this->hasMany('App\Session');
    }

    public function schedules()
    {
        return $this->hasMany('App\Schedule');
    }
}
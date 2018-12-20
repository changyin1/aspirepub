<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	protected $fillable = [
        'start_date', 'end_date', 'city', 'country'
    ];

    public function user()
    {
        return $this->hasMany('App\User');
    }

    public function sessions()
    {
        return $this->hasMany('App\Session');
    }

    public function schedules()
    {
        return $this->hasMany('App\Schedule');
    }
}

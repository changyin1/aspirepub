<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	protected $fillable = [
        'start_date', 'end_date', 'address', 'city', 'state', 'zip', 'country', 'timezone'
    ];

    public function user()
    {
        return $this->hasMany('App\User');
    }

    public function sessions()
    {
        return $this->hasMany('App\Session');
    }

    public function campaigns()
    {
        return $this->hasMany('App\Campaign');
    }
}

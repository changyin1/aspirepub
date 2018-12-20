<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'start_date', 'end_date', 'calls', 'client_id', 'recpients'
    ];

    protected $dates = [
        'start_date','end_date'
    ];

    public function sessions()
    {
        return $this->hasMany('App\Session');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}

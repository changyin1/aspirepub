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

    public function calls()
    {
        return $this->hasMany('App\Call');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}

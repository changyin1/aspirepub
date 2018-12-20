<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
	protected $fillable = [
        'client_id', 'coach_id', 'schedule_id', 'notes'
    ];
    
    public function coach()
    {
        return $this->belongsTo('App\Coach');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function scribe()
    {
        return $this->belongsTo('App\Scribe');
    }

    public function schedule()
    {
        return $this->belongsTo('App\Schedule');
    }

    public function user()
    {
        return $this->coach()->id;
    }
}

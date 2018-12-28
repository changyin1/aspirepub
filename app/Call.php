<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
	protected $fillable = [
        'client_id', 'coach_id', 'call_specialist_id', 'schedule_id', 'caller_notes', 'coach_notes', 'call_score'
    ];
    
    public function coach()
    {
        return $this->belongsTo('App\User');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function call_specialist()
    {
        return $this->belongsTo('App\User');
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

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
	protected $fillable = [
        'client_id', 'coach_id', 'call_specialist_id', 'schedule_id', 'caller_notes', 'coach_notes', 'call_score', 'reservation_confirmation', 'cancelation_confirmation', 'arrival_date', 'departure_date', 'agent_name'
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'departure_date' => 'date'
    ];

    public function coach()
    {
        if ($this->coach) {
            $user = User::where('id', $this->coach)->first();
            return $user;
        }
        return '';
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function call_specialist()
    {
        if ($this->call_specialist) {
            $user = User::where('id', $this->call_specialist)->first();
            return $user;
        }
        return '';
    }

    public function schedule()
    {
        return $this->belongsTo('App\Schedule');
    }

    public function user()
    {
        return $this->coach()->id;
    }

    public function recording()
    {
        return $this->belongsTo('App\Recording');
    }

    public function transcript()
    {
        return $this->belongsTo('App\Transcripts');
    }

    public function client_name() {
        if ($this->client) {
            return $this->client->name;
        }
        return '-';
    }

    public function assigned() {
        return $this->hasMany('App\CallAssignment');
    }
}

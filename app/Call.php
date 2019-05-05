<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function week() {
        $day = Carbon::parse($this->due_date)->format('d');
        $week = ($day - 1) / 7;
        return $week;
    }

    public function assignmentDate() {
        $monthDay = Carbon::parse($this->due_date)->format('Y-m');
        $day = Carbon::parse($this->due_date)->subDays(7)->format('d');

        return $monthDay . '-' . $day;
    }

    public function due() {
        if ($this->completed_at) {
            return 1;
        }
        switch (true) {
            case $this->due_date <= \Carbon\Carbon::now()->addDays(1):
                return 3;
                break;
            case $this->due_date <= \Carbon\Carbon::now()->addDays(7):
                return 2;
                break;
            default:
                return 1;
                break;
        }
    }

    public function claimed() {
        if ($this->call_specialist) {
            return true;
        }
        return false;
    }

    public function scores() {
        $scores = Score::where('call_id', $this->id)->get();
        $scoreArray = [];
        foreach ($scores as $score) {
            $scoreArray[$score->question_id] = $score->score;
        }

        return $scoreArray;
    }
}

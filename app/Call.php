<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Call extends Model
{
	protected $fillable = [
        'client_id', 'coach', 'call_specialist_id', 'schedule_id', 'caller_notes', 'coach_notes', 'call_score', 'reservation_confirmation', 'cancelation_confirmation', 'arrival_date', 'departure_date', 'agent_name', 'due_date'
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'departure_date' => 'date'
    ];

    protected $attributes = [
        'reservation_made' => false,
        'aspire_card_used' => false,
        'custom_agent_id' => 0,
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
        $offset = $day % 7;
        $week = ($day - $offset) / 7;
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
            $scoreArray[$score->question_id] = [
                'score' => $score->score,
                'note' => $score->note
            ];
        }

        return $scoreArray;
    }

    public function reservationToBeCancelled() {
        if ($this->reservation_made && !$this->cancelation_confirmation) {
            $reservationMadeTime = Carbon::parse($this->completed_at);
            $now = Carbon::now();
            if ($reservationMadeTime->addHour(18) < $now) {
                return true;
            }
        }

        return false;
    }

    public function customAgentName() {
        if ($this->custom_agent_id) {
            $agent = CustomAgent::where('id', $this->custom_agent_id)->first();
            return $agent->agent_name;
        }

        return null;
    }

    public function callerAmount() {
        $schedule = $this->schedule;
        if (!$schedule) {
            return 'Schedule No Longer Exists';
        }
        $callType = $schedule->callType;
        if (!$callType) {
            $callType = CallType::where('type', 'Standard')->orWhere('type', 'Default')->first();
        }
        return $callType->caller_amount;
    }

    public function coachAmount() {
        $schedule = $this->schedule();
        if (!$schedule) {
            return 'Schedule No Longer Exists';
        }
        $callType = $schedule->callType;
        if (!$callType) {
            $callType = CallType::where('type', 'Standard')->orWhere('type', 'Default')->first();
        }
        return $callType->coach_amount;
    }

    public function canBeSubmitted() {
        if (Carbon::now()->toDateString() > $this->due_date) {
            return true;
        }
        $daysToAdd = 7 - (Carbon::now()->day % 7);
        $endOfWeek = Carbon::now()->addDays($daysToAdd)->toDateString();

        return $this->due_date == $endOfWeek;
    }
}

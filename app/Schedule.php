<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{
    protected $fillable = [
        'start_date', 'end_date', 'calls', 'client_id', 'recpients', 'questionstemplates_id'
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

    public function questiontemplate()
    {
        return $this->belongsTo('App\QuestionTemplate', 'questionstemplates_id');
    }

    public function customAgents()
    {
        return $this->hasMany('App\CustomAgent', 'schedule');
    }

    public function customAgentsNotContacted()
    {
        return $this->customAgents()->where('contacted', '=', 0);
    }

    public function client_name() {
        if ($this->client) {
            return $this->client->name;
        }
        return '-';
    }

    public function template_name() {
        if ($this->questiontemplate) {
            return $this->questiontemplate->template_name;
        }
        return '-';
    }

    public function finalize() {
        $numberOfCalls = $this->calls;
        for($i = 1; $i <= $numberOfCalls; $i++) {
            $newCall = new Call;
            $newCall->client_id = $this->client_id;
            $newCall->schedule_id = $this->id;
            $dueDate = Carbon::parse($this->start_date)->addDays(7 * ($i % 4) - 1);
            $newCall->due_date = $dueDate->toDateTimeString();
            $newCall->save();
        }

        return true;
    }

    public function addCalls($numberOfCalls, $week) {
        $this->calls = $this->calls + $numberOfCalls;
        for($i = 1; $i <= $numberOfCalls; $i++) {
            $newCall = new Call;
            $newCall->client_id = $this->client_id;
            $newCall->schedule_id = $this->id;
            $dueDate = Carbon::parse($this->start_date)->addDays(7 * ($week) - 1);
            $newCall->due_date = $dueDate->toDateTimeString();
            $newCall->save();
        }
        $this->save();
        return true;
    }

    public function duplicate($start, $end) {
        $new = new Schedule;
        $new->start_date = $start;
        $new->end_date = $end;
        $new->client_id = $this->client_id;
        $new->calls = $this->calls;
        $new->questionstemplates_id = $this->questionstemplates_id;
        $new->finalized = true;

        $new->save();

        $calls = Call::where('schedule_id', $this->id)->get();

        foreach($calls as $call) {
            $copyCall = new Call;
            $copyCall->client_id = $call->client_id;
            $copyCall->schedule_id = $new->id;
            $copyCall->coach = $this->coach;
            $dueDate = Carbon::parse($start)->addDays(7 * ($call->week()));
            $copyCall->due_date = $dueDate->toDateTimeString();
            $copyCall->save();

            $assignments = CallAssignment::where('call_id', $call->id)->get();
            foreach($assignments as $assignment) {
                $newAssignment = new CallAssignment;
                $newAssignment->call_id = $copyCall->id;
                $newAssignment->specialist_id = $assignment->specialist_id;
                $newAssignment->save();
            }
        }
        return true;
    }
}

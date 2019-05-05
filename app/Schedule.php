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
            $newCall = new Call();
            $newCall->client_id = $this->client_id;
            $newCall->schedule_id = $this->id;
            $dueDate = Carbon::parse($this->start_date)->addDays(7 * ($i % 4));
            $newCall->due_date = $dueDate->toDateTimeString();
            $newCall->save();
        }

        return true;
    }
}

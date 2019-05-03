<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'score'
    ];

    protected $dates = [
        'start_date','end_date'
    ];

    public function call()
    {
        $this->belongsTo('App\Call');
    }

    public function question()
    {
        $this->belongsTo('App\question');
    }
}

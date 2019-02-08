<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transcripts extends Model
{
    public function call()
    {
        return $this->belongsTo('App\Call');
    }
}

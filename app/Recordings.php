<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recordings extends Model
{

    public function call()
    {
        return $this->belongsTo('App\Call');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallAssignment extends Model
{
    public $timestamps = false;

    public function specialist() {
        return User::where('id', $this->specialist_id)->first();
    }

    public function call() {
        return $this->belongsTo('App\Call');
    }
}

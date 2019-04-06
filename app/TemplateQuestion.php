<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplateQuestion extends Model
{

    public function schedule()
    {
        return $this->belongsTo('App\Schedule');
    }

}

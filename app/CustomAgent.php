<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomAgent extends Model
{
    protected $table = 'schedule_custom_agents';

    protected $fillable = [
        'agent_name','schedule','contacted'
    ];


}

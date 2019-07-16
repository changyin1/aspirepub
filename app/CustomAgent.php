<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CustomAgent extends Model
{
    protected $table = 'schedule_custom_agents';

    protected $fillable = [
        'agent_name','schedule','contacted'
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('agent_name', 'asc');
        });
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CallType extends Model
{
    protected $fillable = [
        'type', 'caller_amount', 'coach_amount', 'grandfather_amount'
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('type', 'asc');
        });
    }
}

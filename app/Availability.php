<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = [
        'user_id', 'date', 'available'
    ];

    protected $table = 'availability';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

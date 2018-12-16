<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scribe extends Model
{
	protected $fillable = [
        'user_id', 'languages'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

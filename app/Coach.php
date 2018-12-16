<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{

	protected $fillable = [
        'user_id', 'languages'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}

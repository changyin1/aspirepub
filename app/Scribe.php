<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scribe extends Model
{
	protected $fillable = [
        'user_id', 'languages'
    ];
    
    protected $casts = [
		'languages' => 'array',
	];
	
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

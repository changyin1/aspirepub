<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientQuestion extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}

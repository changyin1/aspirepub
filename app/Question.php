<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	public function template()
    {
        return $this->belongsTo('App\QuestionTemplate')->orderBy('order');
    }
}

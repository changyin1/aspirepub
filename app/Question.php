<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TemplateQuestion;
use App\QuestionTemplate;

class Question extends Model
{
	public function template()
    {
        return $this->belongsTo('App\QuestionTemplate')->orderBy('order');
    }

    public function templates() {
	    $templateQuestions = TemplateQuestion::where('question_id', $this->id)->get();
	    $templates = [];
	    foreach($templateQuestions as $templateQuestion) {
	        $templates[] = QuestionTemplate::where('id', $templateQuestion->template_id)->first();
        }
	    return $templates;
    }
}

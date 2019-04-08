<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionTemplate extends Model
{
    protected $table = 'questions_templates';

    public function questionCount()
    {
        return TemplateQuestion::where('template_id', $this->id)->count();
    }

    public function questions()
    {
        return $this->hasMany('App\TemplateQuestion', 'template_id')->orderBy('order');
    }

    public function allQuestions()
    {
        return Question::join('template_questions', 'questions.id', '=', 'template_questions.question_id')->where('template_questions.template_id', $this->id)->get();
    }
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    public function schedule()
    {
        return $this->belongsTo('App\Schedule', 'questions_template_id');
    }

}

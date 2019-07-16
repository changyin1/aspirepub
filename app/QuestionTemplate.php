<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Schedule;
use Illuminate\Database\Eloquent\Builder;

class QuestionTemplate extends Model
{
    protected $table = 'questions_templates';

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('template_name', 'asc');
        });
    }

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
        return Question::join('template_questions', 'questions.id', '=', 'template_questions.question_id')->where('template_questions.template_id', $this->id)->where('questions.active', true)->get();
    }
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    public function schedule()
    {
        return $this->belongsTo('App\Schedule', 'questionstemplates_id');
    }

    public function used() {
        $edit = false;
        $schedules = Schedule::where('questionstemplates_id', $this->id)->get();
        foreach ($schedules as $schedule) {
            if($schedule->start_date->isPast()) {
                $edit = true;
            }
        }
        return $edit;
    }

}

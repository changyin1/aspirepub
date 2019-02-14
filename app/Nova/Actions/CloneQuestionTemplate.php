<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use \App\TemplateQuestion;
use \App\QuestionTemplate;

class CloneQuestionTemplate extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {    
        foreach ($models as $model) {
            //Make sure new name does not exist
            if (QuestionTemplate::where('template_name', $fields['new_template_name'])->count() > 0) {
                return Action::message('Template already exists. Pick a new name.');
            } else {
                $new_template = new QuestionTemplate;
                $new_template->template_name = $fields['new_template_name'];
                $new_template->active = 1;
                $new_template->save();

                $old_template = $model;

                $old_template_questions = TemplateQuestion::where('template_id', $old_template->id)->where('active', 1)->get();
                foreach ($old_template_questions as $template_question) {
                    $tq = new TemplateQuestion;
                    $tq->template_id = $new_template->id;
                    $tq->question_id = $template_question->question_id;
                    $tq->active = 1;

                    //Check if already exists
                    $existing = TemplateQuestion::where('template_id', $tq->template_id)->where('question_id', $tq->id)->first();
                    if($existing) {
                        $existing->active = 1;
                        $existing->save();
                    } else {
                        $tq->save();    
                    }
                }    
            }

        }           
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        $templates = \App\QuestionTemplate::all()->pluck('template_name', 'id');        
        return [            
            Text::make('New Template Name'),
        ];
    }
}

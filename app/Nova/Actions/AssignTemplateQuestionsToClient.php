<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Laravel\Nova\Fields\Select;
use \App\Question;
use \App\ClientQuestion;
use \App\TemplateQuestion;

class AssignTemplateQuestionsToClient extends Action
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
        /*
        foreach ($models as $model) {
            $template_questions = TemplateQuestion::where('active', 1)->where('template_id',$model->id)->get();
            return Action::message(count($template_questions);
        }
        */
        
        foreach ($models as $model) {            
            $template_questions = TemplateQuestion::where('active', 1)->where('template_id',$model->id)->get();
            foreach ($template_questions as $template_question) {
                $question = Question::find($template_question->question_id);
                $cq = new ClientQuestion;
                $cq->question_id = $question->id;
                $cq->client_id = $fields['client'];
                $cq->question = $question->question;
                $cq->type = $question->type;
                $cq->weight = $question->weight;

                //Check if already exists
                $existing = ClientQuestion::where('client_id', $fields['client'])->where('question_id', $question->id)->first();
                if($existing) {
                    $existing->active = 1;
                    $existing->save();
                } else {
                    $cq->save();    
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
        $clients = \App\Client::all()->pluck('name', 'id');        
        return [
            Select::make('Client')->options($clients),
        ];        
    }
}

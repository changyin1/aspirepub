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
use \App\TemplateQuestion;

class AddQuestionToTemplate extends Action
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
            $tq = new TemplateQuestion;
            $tq->template_id = $fields['template'];
            $tq->question_id = $model->id;
            $tq->active = 1;

            //Check if already exists
            $existing = TemplateQuestion::where('template_id', $fields['template'])->where('question_id', $model->id)->first();
            if($existing) {
                $existing->active = 1;
                $existing->save();
            } else {
                $tq->save();    
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
            Select::make('Template')->options($templates),
        ];
    }
}

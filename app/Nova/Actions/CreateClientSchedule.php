<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use App\Schedule;

class CreateClientSchedule extends Action
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
        $calls = $fields['calls_per_month'];
        
        for( $i = 4; $i>0; $i-- ) {
            $calls_this_week = ceil($calls/($i));
            $schedule = new Schedule;
            $schedule->week = 5-$i;
            $start_day_num = $schedule->week * 7 - 6;
            $strtotime = strtotime($fields['month'] . ' ' . $start_day_num . '  2019');
            $schedule->start_date = date('Y-m-d 00:00:00', $strtotime);
            $start_day_num = $schedule->week * 7;
            $strtotime = strtotime($fields['month'] . ' ' . $start_day_num . '  2019');
            $schedule->end_date = date('Y-m-d 23:59:59', $strtotime);
            $schedule->calls = $calls_this_week;
            $schedule->client_id = $models[0]->id;
            if($fields['type'] == 'standard') {
                $schedule->contact = 'Anyone';    
            } else {
                $schedule->contact = 'TBD';
            }            
            $schedule->save();
            $calls = $calls - $calls_this_week;
        }
        //return Action::message($calls_this_week);
        
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Number::make('Calls Per Month'),
            Select::make('Month')->options([
                'jan' => 'Jan',
                'feb' => 'Feb',
                'mar' => 'Mar',
                'apr' => 'Apr',
                'may' => 'May',
                'jun' => 'Jun',
                'jul' => 'Jul',
                'aug' => 'Aug',
                'sep' => 'Sep',
                'oct' => 'Oct',
                'nov' => 'Nov',
                'dec' => 'Dec',                
            ]),
            Select::make('Type')->options([
                'standard' => 'Standard',
                'custom' => 'Custom',            
            ]),
        ];
    }
}

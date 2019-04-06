<?php

namespace App\Observers;

use App\Schedule;
use App\Call;

class ScheduleObserver
{

    public function creating(Schedule $schedule)
    {

    }
    /**
     * Handle the schedule "created" event.
     *
     * @param  \App\Schedule  $schedule
     * @return void
     */
    public function created(Schedule $schedule)
    {
        $calls = $schedule->calls;

        for( $i = 1; $i<5; $i++ ) {
            $day_add = ($i * 7) - 1;
            $end_date = date('Y-m-d', strtotime($schedule->start_date. ' + '.$day_add.' days'));
            if($end_date > $schedule->end_date) {
                $end_date = $schedule->end_date;
            }
            $calls_this_week = ceil($calls/(4));
            for($c = $calls_this_week; $c>0; $c-- ) {
                $call = new Call();

                $call->client_id = $schedule->client_id;
                $call->schedule_id = $schedule->id;
                $call->call_specialist = $schedule->call_specialist;
                $call->coach = $schedule->coach;
                $call->due_date = $end_date;

                $call->save();
            }
        }
    }

    /**
     * Handle the schedule "updated" event.
     *
     * @param  \App\Schedule  $schedule
     * @return void
     */
    public function updated(Schedule $schedule)
    {
        //
    }

    /**
     * Handle the schedule "deleted" event.
     *
     * @param  \App\Schedule  $schedule
     * @return void
     */
    public function deleted(Schedule $schedule)
    {
        //
    }

    /**
     * Handle the schedule "restored" event.
     *
     * @param  \App\Schedule  $schedule
     * @return void
     */
    public function restored(Schedule $schedule)
    {
        //
    }

    /**
     * Handle the schedule "force deleted" event.
     *
     * @param  \App\Schedule  $schedule
     * @return void
     */
    public function forceDeleted(Schedule $schedule)
    {
        //
    }
}

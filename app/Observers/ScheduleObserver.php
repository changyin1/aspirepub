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
        //
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

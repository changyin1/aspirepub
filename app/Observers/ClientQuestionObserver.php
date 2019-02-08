<?php

namespace App\Observers;

use App\ClientQuestion;

class ClientQuestionObserver
{
    /**
     * Handle the client question "created" event.
     *
     * @param  \App\ClientQuestion  $clientQuestion
     * @return void
     */
    public function created(ClientQuestion $clientQuestion)
    {
        //
    }

    /**
     * Handle the client question "updated" event.
     *
     * @param  \App\ClientQuestion  $clientQuestion
     * @return void
     */
    public function updated(ClientQuestion $clientQuestion)
    {
        //
    }

    /**
     * Handle the client question "deleted" event.
     *
     * @param  \App\ClientQuestion  $clientQuestion
     * @return void
     */
    public function deleted(ClientQuestion $clientQuestion)
    {
        $clientQuestion->active = 0;
        $clientQuestion->save();
    }

    /**
     * Handle the client question "deleting" event.
     *
     * @param  \App\ClientQuestion  $clientQuestion
     * @return void
     */
    public function deleting(ClientQuestion $clientQuestion)
    {
        //
    }

    /**
     * Handle the client question "restored" event.
     *
     * @param  \App\ClientQuestion  $clientQuestion
     * @return void
     */
    public function restored(ClientQuestion $clientQuestion)
    {
        //
    }

    /**
     * Handle the client question "force deleted" event.
     *
     * @param  \App\ClientQuestion  $clientQuestion
     * @return void
     */
    public function forceDeleted(ClientQuestion $clientQuestion)
    {
        //
    }
}

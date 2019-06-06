<?php

namespace App\Observers;

use App\Call;
use App\Client;
use App\Mail\CallPosted;
use App\Mail\CancelReservation;
use App\Mail\CallScoreDue;
use Mockery\Exception;
use Illuminate\Support\Facades\Mail;

class CallObserver
{
    /**
     * Handle the call "created" event.
     *
     * @param  \App\Call  $call
     * @return void
     */
    public function created(Call $call)
    {
        //
    }

    /**
     * Handle the call "updated" event.
     *
     * @param  \App\Call  $call
     * @return void
     */
    public function updated(Call $call)
    {
        if($call->isDirty('completed_at')) {
            $client = Client::where('client_id', $call->client);
            $coach = User::where('id', $call->coach);
            foreach ($client->reservationContacts() as $contact) {
                try {
                    Mail::to(trim($contact))->send(new CallPosted($client, $call));
                } catch (Exception $e) {

                }
            }
            foreach ($client->cancellationEmails() as $email) {
                try {
                    Mail::to(trim($email))->send(new CallPosted($client, $call));
                } catch (Exception $e) {

                }
            }
            try {
                Mail::to($coach->email)->send(new CallScoreDue($coach, $call));
            } catch (Exception $e) {

            }
        }
    }

    /**
     * Handle the call "deleted" event.
     *
     * @param  \App\Call  $call
     * @return void
     */
    public function deleted(Call $call)
    {
        //
    }

    /**
     * Handle the call "restored" event.
     *
     * @param  \App\Call  $call
     * @return void
     */
    public function restored(Call $call)
    {
        //
    }

    /**
     * Handle the call "force deleted" event.
     *
     * @param  \App\Call  $call
     * @return void
     */
    public function forceDeleted(Call $call)
    {
        //
    }
}

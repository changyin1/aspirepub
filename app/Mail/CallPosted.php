<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Client;
use App\Call;

class CallPosted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Client $client, Call $call)
    {
        $this->client = $client;
        $this->call = $call;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'name' => $this->client->name,
            'completed_date' => $this->call->completed_at
        ];
        return $this->view('emails.call_posted')
            ->with($data);
    }
}

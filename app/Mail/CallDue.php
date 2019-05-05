<?php

namespace App\Mail;

use App\Call;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CallDue extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Call $call)
    {
        $this->user = $user;
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
            'name' => $this->user->name,
            'due_date' => $this->call->due_date
        ];

        return $this->view('emails.call_due')
            ->with($data);
    }
}

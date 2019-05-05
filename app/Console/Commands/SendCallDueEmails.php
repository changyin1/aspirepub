<?php

namespace App\Console\Commands;

use App\Call;
use App\Mail\CallDue;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCallDueEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:call_due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notice to call specialist call is due';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tomorrow = Carbon::today()->addDays(1)->toDateString();
        $calls = Call::where('due_date', $tomorrow)->get();
        if (!$calls->isEmpty()) {
            foreach ($calls as $call) {
                if ($call->call_specialist) {
                    $user = User::where('id', $call->call_specialist)->first();
                    Mail::to($user->email)->send(new CallDue($user, $call));
                } else {
                    $assigned = $call->assigned;
                    foreach ($assigned as $assignment) {
                        $user = User::where('id', $assignment->specialist_id);
                        Mail::to($user->email)->send(new CallDue($user, $call));
                    }
                }
            }
        }

        Log::info('Sending call due emails for cals due: '. $tomorrow);
    }
}

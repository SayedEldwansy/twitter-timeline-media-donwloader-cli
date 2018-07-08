<?php

namespace App\Console\Commands;

use App\Models\MessageQueues;
use App\Models\User;
use Illuminate\Console\Command;
use Twitter;

class SendMessages extends Command
{

    protected $signature = 'messages:send';


    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $user = User::where('username', '_A_jamal')->first();
        Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
        foreach (MessageQueues::where('send', 0)->limit(300)->get() as $message) {
            try {
                $msg = $message->message . "\n\r".
                    "See More : ".url('/');


                Twitter::postDm(['user_id' => $message->user->t_id, 'text' => $msg]);
                $message->update(['send' => 1]);
            } catch (\Exception $exception) {
                $message_user = $message->user;
                Twitter::reconfig(['token' => $message_user->token, 'secret' => $message_user->token_secret]);
                Twitter::postFollow(['screen_name' => '_A_jamal']);
                Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
                continue;
            }

        }
    }
}

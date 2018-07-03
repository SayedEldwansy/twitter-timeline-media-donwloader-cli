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
        $user = User::where('username', '__201_')->first();
        Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
        foreach (MessageQueues::where('send', 0)->limit(300)->get() as $message) {
            Twitter::postDm(['user_id' => $message->user->t_id, 'text' => $message->message]);
            $message->update(['send'=>1]);
        }
    }
}

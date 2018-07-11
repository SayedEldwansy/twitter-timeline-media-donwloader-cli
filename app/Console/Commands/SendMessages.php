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
        try {

            foreach (MessageQueues::where('send', 0)->limit(300)->get() as $message) {
                try {
                    $this->FollowMe($message);
                    $user = User::where('username', '_Blue_Helper_')->first();
                    Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
                    $msg = $message->message . "\n\r" . "\n\r" .
                        "See More : " . url('/');
                    Twitter::postFollow(['user_id'=>$message->user->t_id]);
                    Twitter::postDm(['user_id' => $message->user->t_id, 'text' => $msg]);
                    $message->update(['send' => 1]);
                } catch (\Exception $exception) {
                    $this->FollowMe($message, $user);
                    continue;
                }

            }
        } catch (\Exception $e) {
            \Log::info("sending message command ");
            \Log::info($exception->getMessage());
            \Log::info($exception->getLine());
            \Log::info($exception->getFile());
            \Log::info($user->username);
        }

    }

    /**
     * @param $message
     * @param $user
     */
    private function FollowMe($message): void
    {
        $message_user = $message->user;
        Twitter::reconfig(['token' => $message_user->token, 'secret' => $message_user->token_secret]);
        Twitter::postFollow(['screen_name' => '_Blue_Helper_']);
    }
}

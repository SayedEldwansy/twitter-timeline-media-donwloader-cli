<?php

namespace App\Console\Commands;

use App\Models\DeleteMyTweet;
use Illuminate\Console\Command;
use \Twitter;

class DeleteTweet extends Command
{

    protected $signature = 'delete:tweet';


    protected $description = 'Command description';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $this->HandelCommand();
    }

    private function HandelCommand()
    {
        foreach (DeleteMyTweet::all() as $deleteCommand) {
            $user = $deleteCommand->user;
            $this->DeleteTweets($user);
            $deleteCommand->delete();
        }
    }


    private function DeleteTweets($user, $max_id = null)
    {
        Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
        $page = $this->getTimeLinePage($user, $max_id);
        if (count($page) > 0) {
            $max_id = last($page)->id;
            foreach ($page as $tweet) {
                Twitter::destroyTweet($tweet->id);
            }
            if ($max_id) $this->DeleteTweets($user, $max_id);
        }
        return false;


    }

    private function getTimeLinePage($user, $max_id = null)
    {
        $call_data_array = ['screen_name' => $user->username, 'count' => 20];
        if ($max_id) {
            $call_data_array = array_add($call_data_array, 'max_id', $max_id);
        }
        $tweets = \Twitter::getUserTimeline($call_data_array);
        return $tweets;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\DeleteMyTweet;
use Illuminate\Console\Command;
use \Twitter;

class DeleteTweet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:tweet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        foreach (DeleteMyTweet::all() as $deleteCommand) {
            $user = $deleteCommand->user;
            Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
        }
    }

    private function getTimeLinePage($user, $max_id)
    {
        $call_data_array = ['screen_name' => $user->username, 'count' => 20];
        if ($max_id) {
            $call_data_array = array_add($call_data_array, 'max_id', $max_id);
        }
        $tweets = \Twitter::getUserTimeline($call_data_array);
    }
}

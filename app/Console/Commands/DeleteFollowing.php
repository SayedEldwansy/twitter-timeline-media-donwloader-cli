<?php

namespace App\Console\Commands;

use App\Models\DeleteMyFollowing;
use Illuminate\Console\Command;
use Twitter;

class DeleteFollowing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:following';

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
        $this->HandelCommand();
    }

    public function HandelCommand()
    {
        foreach (DeleteMyFollowing::all() as $deleteCommand) {
            $user = $deleteCommand->user;
            Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
            $friends = $this->GetFriendsArray();
            foreach ($friends as $friend) {
                Twitter::postUnfollow(['user_id' => $friend]);
                $wait = rand(1, 60);
                $this->info('unfollow user : ' . $friend . " ->wait " . $wait);
                sleep($wait);
            }
            $deleteCommand->delete();
        }
    }

    public function GetFriendsArray($next_cursor = null)
    {
        $friends = [];
        try {
            $call_data = [];
            if ($next_cursor) {
                $call_data['cursor'] = $next_cursor;
            }
            $api_data = Twitter::getFollowersIds($call_data);
            $friends = array_merge($friends, $api_data->ids);
            if ($api_data->next_cursor > 0) {
                $this->GetFriendsArray($api_data->next_cursor);
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }

        return $friends;
    }
}

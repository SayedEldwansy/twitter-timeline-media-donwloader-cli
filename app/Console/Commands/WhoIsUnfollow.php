<?php

namespace App\Console\Commands;

use App\DaleyUserFollwers;
use App\User;
use Illuminate\Console\Command;
use function PHPSTORM_META\type;
use Twitter;

class WhoIsUnfollow extends Command
{

    protected $signature = 'users:unfollow';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->main();
    }

    public function main()
    {
        foreach (User::all() as $user) {
            Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
            $followers = $this->GetFollowersArray();
            DaleyUserFollwers::create([
                'user_id' => $user->id,
                'followers' => $followers,
            ]);
        }
    }

    public function GetFollowersArray($next_cursor = null)
    {
        $followers = [];
        $call_data = [];
        if ($next_cursor) {
            $call_data['cursor'] = $next_cursor;
        }
        $api_data = Twitter::getFollowersIds($call_data);
        $followers = array_merge($followers, $api_data->ids);
        if ($api_data->next_cursor > 0) {
            $this->GetFollowersArray($api_data->next_cursor);
        }
        return $followers;
    }


}

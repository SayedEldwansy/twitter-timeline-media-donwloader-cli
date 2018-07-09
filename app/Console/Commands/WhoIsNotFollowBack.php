<?php

namespace App\Console\Commands;

use App\Models\DaleyUserFriends;
use App\Models\User;
use App\Models\NotFollowBack;
use Illuminate\Console\Command;
use Log, Twitter;

class WhoIsNotFollowBack extends Command
{

    protected $signature = 'command:who-is-not-follow-back';


    protected $description = 'Command description';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        foreach (User::all() as $user) {
            try {
                Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
                $friends = $this->GetFriendsArray();
                DaleyUserFriends::create([
                    'user_id' => $user->id,
                    'friends' => $friends,
                ]);
                $notFollowBack = array_diff($user->DaleyFriends()->latest()->first()->friends, $user->DaleyFollowers()->latest()->first()->followers);
                $not_follow_back_row = NotFollowBack::firstOrCreate(['user_id' => $user->id]);
                $not_follow_back_row->not_follow_back = array_values($notFollowBack);
                $not_follow_back_row->save();
            } catch (\Exception $exception) {
                \Log::info("who-is-not-follow-back command");
                \Log::info($exception->getMessage());
                \Log::info($exception->getLine());
                \Log::info($exception->getFile());
                \Log::info($user->username);
            }
        }
    }

    public function GetFriendsArray($next_cursor = null)
    {
        $friends = [];
        $call_data = [];
        if ($next_cursor) {
            $call_data['cursor'] = $next_cursor;
        }
        $api_data = Twitter::getFriendsIds($call_data);
        $friends = array_merge($friends, $api_data->ids);
        if ($api_data->next_cursor > 0) {
            $this->GetFriendsArray($api_data->next_cursor);
        }
        return $friends;
    }
}

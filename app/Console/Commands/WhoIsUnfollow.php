<?php

namespace App\Console\Commands;

use App\Models\DaleyUserFollwers;
use App\Models\MessageQueues;
use App\Models\User;
use Illuminate\Console\Command;
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
            try {
                Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
                $followers = $this->GetFollowersArray();
                DaleyUserFollwers::create([
                    'user_id' => $user->id,
                    'followers' => $followers,
                ]);
                $last2rows = $user->DaleyFollowers()->latest()->limit(2)->pluck('followers');
                if (count($last2rows) == 2) {
                    $diff = array_diff($last2rows[1], $last2rows[0]);
                    if (count($diff) > 0) {
                        $whoIsUnfollow = [];
                        $peoples = Twitter::getUsersLookup(['user_id' => $diff]);
                        foreach ($peoples as $people) {
                            $whoIsUnfollow[] = $people->screen_name;
                        }
                        $messagetext = "الناس ال عملتلك انفولو :";
                        foreach ($whoIsUnfollow as $item) {
                            $messagetext .=  " @$item 
                            ,
                            
                        ";

                        }
                        MessageQueues::create([
                            'user_id' => $user->id,
                            'message' => $messagetext,
                        ]);
                    }
                }
            } catch (\Exception $exception) {
                Log::info($exception->getMessage(), $exception->getLine(), $exception->getFile());
            }

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

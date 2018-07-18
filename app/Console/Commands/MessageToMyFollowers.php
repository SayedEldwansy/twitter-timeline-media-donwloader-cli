<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twitter, App\Models\User;

class MessageToMyFollowers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:to-my-followers {message} {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send message for every on follow me';

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
        try {
            $user = User::where('username', $this->argument('user'))->first();
            $counter = 0;
            if ($user) {
                $massage = $this->argument('message');
                Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
                $friends = $this->GetFriendsArray();
                $this->info('recipient :' .count($friends));
                foreach ($friends as $person) {
                    $counter++;
                    $this->info('send to ' . $person);
                    $send = Twitter::postDm(['user_id' => $person, 'text' => $massage]);
                    $this->info("send to : ".$send->recipient->name .' http://twitter.com/'.$send->recipient->screen_name);
                }

            }
        } catch (\Exception $exception) {
            \Log::info("message:to-my-followers command ");
            \Log::info($exception->getMessage());
            \Log::info($exception->getLine());
            \Log::info($exception->getFile());
            \Log::info($user->username);
        }


    }
    public function GetFriendsArray($next_cursor = null)
    {
        $friends = [];
        $call_data = [];
        if ($next_cursor) {
            $call_data['cursor'] = $next_cursor;
        }
        $api_data = Twitter::getFollowersIds($call_data);
        $friends = array_merge($friends, $api_data->ids);
        if ($api_data->next_cursor > 0) {
            $this->GetFriendsArray($api_data->next_cursor);
        }
        return $friends;
    }


}
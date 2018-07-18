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
            if ($user) {
                $massage = $this->argument('message');
                Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
                $followers = $user->DaleyFriends()->latest()->first()->friends;
                foreach ($followers as $person) {
                    $this->info('send to ' . $person);
                    $this->info($massage);
                    Twitter::postDm(['user_id' => $person, 'text' => $massage]);
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


}
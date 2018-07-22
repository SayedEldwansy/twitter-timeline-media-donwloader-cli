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
        foreach (DeleteMyFollowing::inRandomOrder()->get() as $deleteCommand) {
            try {
                $user = $deleteCommand->user;
                Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
                $friends = Twitter::getFriendsIds(['count'=>20]);;
                $this->info("Friends List : ".count($friends->ids));
                if(count($friends->ids) > 0){
                    foreach ($friends->ids as $friend) {
                        Twitter::postUnfollow(['user_id' => $friend]);
                        $wait = rand(1, 10);
                        $this->info('unfollow user : ' . $friend . " -> wait " . $wait);
                        sleep($wait);
                    }
                }
                else{
                    $deleteCommand->delete();
                }


            } catch (\Exception $e) {
                \Log::info($e->getMessage());
                \Log::info($e->getLine());
                \Log::info($e->getFile());
                \Log::info("Delete following command");
            }

        }
    }


}

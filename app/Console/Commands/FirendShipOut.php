<?php

namespace App\Console\Commands;

use App\Models\MessageQueues;
use App\Models\User;
use Illuminate\Console\Command;
use Twitter;
class FirendShipOut extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:pending-follow';

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
        foreach (User::all() as $user) {
            try{
                Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
                $pinding_ids = Twitter::getFriendshipsOut()->ids;
                if(count($pinding_ids)){
                    $pinding =  Twitter::getUsersLookup(['user_id'=>array_slice($pinding_ids,0,33)]);
                    $names = [];
                    foreach ($pinding as $item){
                        $names[] = $item->screen_name;
                    }
                    MessageQueues::create([
                        'user_id' => $user->id,
                        'message' => 'pending requests : @' . implode(' , @', $names),

                    ]);
                }
            }catch (\Exception $exception){
                \Log::info($user->username);
                \Log::info($exception->getMessage(),$exception->getLine(),$exception->getFile());
            }

        }
    }
}

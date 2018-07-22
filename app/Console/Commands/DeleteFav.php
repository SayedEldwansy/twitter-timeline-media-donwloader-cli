<?php

namespace App\Console\Commands;

use App\Models\DeleteMyFav;
use Illuminate\Console\Command;
use Twitter;
class DeleteFav extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:fav';

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
        $this->handelCommand();
    }

    private function handelCommand()
    {
        foreach (DeleteMyFav::all() as $command){
            $user = $command->user;
            Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
            $fav = Twitter::getFavorites();
            if($fav && count($fav) > 0){
                foreach ($fav as $item){
                    Twitter::destroyFavorite(['id'=>$item->id]);
                }
            }else{
                $command->delete();
            }
        }
    }
}

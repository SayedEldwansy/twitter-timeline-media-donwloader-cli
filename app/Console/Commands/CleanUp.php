<?php

namespace App\Console\Commands;

use App\Models\DaleyUserFollwers;
use App\Models\DaleyUserFriends;
use Illuminate\Console\Command;

class CleanUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cleanup';

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
        \Artisan::call('users:unfollow');
        DaleyUserFriends::truncate();
        DaleyUserFollwers::truncate();
        \Artisan::call('users:unfollow');
        \Artisan::call('command:who-is-not-follow-back');
    }
}

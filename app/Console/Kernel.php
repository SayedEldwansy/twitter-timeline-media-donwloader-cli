<?php

namespace App\Console;

use App\Console\Commands\CleanUp;
use App\Console\Commands\SendMessages;
use App\Console\Commands\WhoIsNotFollowBack;
use App\Console\Commands\WhoIsUnfollow;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\DownloadUsers;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        DownloadUsers::class,
        WhoIsUnfollow::class,
        WhoIsNotFollowBack::class,
        SendMessages::class,
        CleanUp::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('user:pending-follow')->weekly();
        $schedule->command('command:cleanup')->dailyAt('03:30')->timezone('Africa/Cairo');
        $schedule->command('users:unfollow')->hourly();
        $schedule->command('command:who-is-not-follow-back')->hourly();
        $schedule->command('messages:send')->everyFifteenMinutes();
        $schedule->command('delete:tweet')->everyTenMinutes();
        $schedule->command('delete:following')->everyTenMinutes();


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

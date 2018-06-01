<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Twitter;
class UpdateUserFollowing
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
        $following  = Twitter::getFriends();
        dd($following);
    }
}

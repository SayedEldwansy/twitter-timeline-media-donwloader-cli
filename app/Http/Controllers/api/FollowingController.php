<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\api\ApiController;
use Illuminate\Http\Request;
use Twitter;

class FollowingController extends ApiController
{
    public function following()
    {
        $user = auth()->user();
        dd($user);
        return $user;
        Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
        $following  = Twitter::getFriends();
        return $following;
    }
}

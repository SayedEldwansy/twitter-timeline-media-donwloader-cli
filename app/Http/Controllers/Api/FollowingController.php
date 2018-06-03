<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Twitter;

class FollowingController extends ApiController
{
    public function following(Request $request)
    {
        $next_cursor = $request->input('next_cursor', null);
        $user = auth()->user();
        Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
        $call_data = [];
        if ($next_cursor) {
            $call_data['cursor'] = $next_cursor;
        }
//        $following = Twitter::getFriends($call_data);
        $following = \Twitter::getFriendsIds($call_data);
        return response()->json($following);
    }

    public function UserInfo($ids = [])
    {

    }
}

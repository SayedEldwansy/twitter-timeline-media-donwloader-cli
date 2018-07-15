<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\TweetByMeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Twitter;

class UsersController extends ApiController
{
    public function NotFollowBack(Request $request)
    {
        $user = auth()->user();
        $page = $request->page;
        $from = ($page > 0) ? $page + 100 : $page;
        $to = $from + 100;
        Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
        $record = auth()->user()->NotFollowBack()->latest()->first();
        if ($record) {
            $people_list = [];
            $limited_list = array_slice($record->not_follow_back, $from, $to);
//            dd($limited_list);
            $people = $this->getTwitterById($limited_list);
            foreach ($people as $person) {
                $people_list[] = $person;
            }
            return [
                "list_count" => count($record->not_follow_back),
                'list_data' => $people_list
            ];
        } else {
            \Artisan::call('users:unfollow');
            \Artisan::call('command:who-is-not-follow-back');
            return [
                "list_count" => 0,
                'list_data' => []
            ];
        }
    }

    public function getTwitterById($ids)
    {
        return Twitter::getUsersLookup(['user_id' => $ids]);
    }

    public function unFollow(Request $request)
    {
        $screen_name = $request->screen_name;
        $id = $request->id;
        $user = auth()->user();
        Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
        $unfollow = Twitter::postUnfollow(['screen_name' => $screen_name]);
        $record = auth()->user()->NotFollowBack()->latest()->first();
        $not_follow_back = $record->not_follow_back;
        if (($key = array_search($id, $not_follow_back)) !== false) {
            unset($not_follow_back[$key]);
        }
        $record->not_follow_back = $not_follow_back;
        $record->save();
        return $not_follow_back;
    }

    public function tweetByMe(Request $request)
    {
        $request->validate([
            'tweet_string' => 'required'
        ]);
        $user = User::where('username', '_Blue_Helper_')->first();
        Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
        $status = "anonymous tweet : \n\r".$request->tweet_string;
        Twitter::postTweet(['status' => $status]);
        return response()->json([]);
    }
}

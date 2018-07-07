<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Twitter;

class UsersController extends ApiController
{
    public function NotFollowBack(Request $request)
    {
        $user = auth()->user();
        Twitter::reconfig(['token' => $user->token, 'secret' => $user->token_secret]);
        $record = auth()->user()->NotFollowBack()->latest()->first();
        if ($record) {
            $people_list = [];
            $limited_list = array_slice($record->not_follow_back, 0, 600);
            $chunk = array_chunk($limited_list, 100);
            foreach ($chunk as $item) {
                $people = $this->getTwitterById($item);
                foreach ($people as $person) {
                    $people_list[] = $person;
                }
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
        return 1;
    }
}

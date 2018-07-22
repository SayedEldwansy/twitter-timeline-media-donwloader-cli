<?php

namespace App\Http\Controllers;

use App\Models\DeleteMyFav;
use App\Models\DeleteMyFollowing;
use App\Models\DeleteMyTweet;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function DeleteAccount()
    {
        auth()->user()->delete();
        return back();
    }

    public function deleteTweet()
    {
        return view('delete.delete_tweet');
    }

    public function deleteTweetAction()
    {
        DeleteMyTweet::firstOrCreate(['user_id' => auth()->user()->id]);
        flash('Action Created all your tweets will be deleted after 10 minuets as max')->success();
        return back();
    }

    public function deleteFollowing()
    {
        return view('delete.delete_following');
    }

    public function deleteFollowingAction()
    {
        DeleteMyFollowing::firstOrCreate([
            'user_id' => auth()->user()->id
        ]);
        flash('Action Created all your following will be deleted after 10 minuets as max')->success();
        return back();
    }

    public function deleteFavAction()
    {
        DeleteMyFav::firstOrCreate([
            'user_id'=>auth()->user()->id,
        ]);
        flash('Action Created all your Likes will be deleted after 10 minuets as max')->success();
        return back();
    }

    public function deleteFav()
    {
        return view('delete.delete_fav');
    }
}

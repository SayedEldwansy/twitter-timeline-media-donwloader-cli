<?php

namespace App\Http\Controllers;

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
        DeleteMyTweet::create(['user_id' => auth()->user()->id]);
        flash('Action Created all your tweets will be deleted after 10 minuets as max')->success();
        return back();
    }
}

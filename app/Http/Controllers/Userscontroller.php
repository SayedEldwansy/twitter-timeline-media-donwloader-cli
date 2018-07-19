<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Userscontroller extends Controller
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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotFollowBackController extends Controller
{
    public function index(){
        return view('not_follow_back.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\WelcomeMessageCreateRequest;
use App\Models\WelcomeMessage;
use Illuminate\Http\Request;

class WelcomeMessageController extends Controller
{
    public function index()
    {
        return view('welcome_message.index');
    }

    public function store(WelcomeMessageCreateRequest $request)
    {
        WelcomeMessage::create([
            'user_id' => auth()->user()->id,
            'message'=>$request->message,
        ]);
        return back();
    }
}

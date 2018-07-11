<?php

namespace App\Http\Controllers;

use App\Http\Requests\WelcomeMessageCreateRequest;
use App\Models\WelcomeMessage;
use Illuminate\Http\Request;

class WelcomeMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $message = auth()->user()->WelcomeMessage;
        return view('welcome_message.index',compact('message'));
    }

    public function store(WelcomeMessageCreateRequest $request)
    {
        $record = WelcomeMessage::firstOrCreate(['user_id'=>auth()->user()->id]);
        $record->update([
            'user_id' => auth()->user()->id,
            'message'=>$request->message,
        ]);
        return back();
    }
}

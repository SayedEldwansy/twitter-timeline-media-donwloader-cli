<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserLogin;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
    {
        return \Socialite::driver('twitter')->redirect();
    }


    public function handleProviderCallback()
    {
        if (!auth()->check()) {
            $t_user = \Socialite::driver('twitter')->user();
            $user_data = [
                'name' => $t_user->name,
                'username' => $t_user->nickname,
                't_id' => $t_user->id,
                'token' => $t_user->token,
                'token_secret' => $t_user->tokenSecret,
                'email' => $t_user->email,
                'avatar' => $t_user->avatar_original,
                'password' => bcrypt('Php@0101'),
            ];
            $user = User::where('t_id', $t_user->id)->first();
            if (!$user) {
                $user = User::create($user_data);
            }
            $user->update($user_data);
            auth()->loginUsingId($user->id);
        }
//        event(new UserLogin($user));
        return redirect()->to('/');

    }
}

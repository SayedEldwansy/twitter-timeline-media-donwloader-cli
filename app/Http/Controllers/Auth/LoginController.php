<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserLogin;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
    {
        return \Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        if (!auth()->check()) {
            $t_user = \Socialite::driver('twitter')->user();
            $user_data = [
                'username' => $t_user->nickname,
                'name' => $t_user->name,
                't_id' => $t_user->id,
                'email' => $t_user->email,
                'token' => $t_user->token,
                'token_secret' => $t_user->tokenSecret,
                'avatar' => $t_user->avatar_original
            ];
            $user = User::firstOrCreate($user_data);
            if (!$user) {
                $user->update(['password' => bcrypt('Php@0101')]);
            }

            auth()->loginUsingId($user->id);
        }
//        event(new UserLogin($user));
        return redirect()->to('/');

    }
}

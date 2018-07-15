<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace'=>'Api'],function (){
    Route::get('following', 'FollowingController@following');
    Route::get('not-follow-list', 'UsersController@NotFollowBack');
    Route::post('un-follow','UsersController@unFollow');
    Route::post('tweet-by-me','UsersController@tweetByMe');
});

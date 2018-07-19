<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('login/twitter', 'Auth\LoginController@redirectToProvider');
Route::get('login/twitter/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('settings','SettingsController@index')->name('settings')->middleware('auth');
Route::get('welcome-message','WelcomeMessageController@index');
Route::post('welcome-message','WelcomeMessageController@store');
Route::get('not-follow-back','NotFollowBackController@index');
Route::get('anonymous-tweet','HomeController@tweetByMe');
Route::get('delete-account','Userscontroller@DeleteAccount')->name('delete-account');


Route::get('limit',function(){

    $limit =\Twitter::getAppRateLimit();
    dd($limit->resources);
});
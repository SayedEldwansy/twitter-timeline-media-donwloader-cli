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
Route::get('limit',function(){
    dd(\Twitter::getFriendsIds());

    $limit =\Twitter::getAppRateLimit();
    dd($limit);
});
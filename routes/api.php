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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::POST('/login', 'UserController@login');
Route::POST('/signup', 'UserController@signup');
Route::POST('/update_image', 'UserController@updateUserImage');
Route::POST('/update_user_info', 'UserController@updateUserInfo');
Route::POST('/add_song_on_location', 'MusicController@addSongWithLocation');
Route::POST('/get_user_song_list', 'MusicController@getUserSongList');
Route::GET('/get_song_packages', 'PurchaseController@getSongPackages');
Route::POST('/is_track_available', 'MusicController@isTrackAvailable');


Route::POST('/do_purchase_package','PurchaseController@doPurchasePackage');
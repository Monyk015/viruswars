<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

//to view list of all lobbies or one u gotta be authed
Route::resource('lobby','LobbyController');

Route::get('/lobby/{lobbyId}/join/{slotId}','LobbyController@joinSlot')->middleware('auth')->name('joinSlot');

Route::get('/lobby/{lobbyId}/kick/{slotId}', 'LobbyController@kickPlayer')->middleware('auth');

Route::get('/lobby/{lobbyId}/leave/', 'LobbyController@leave')->middleware('auth');
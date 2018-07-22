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


Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::group(['middleware' => 'auth:api'], function(){

    Route::get('details', 'UserController@details');
});

Route::group(['middleware' => 'auth:api', 'as' => 'api.', 'namespace' => 'Api'], function() {
    Route::resource('teams', 'TeamController');
    Route::resource('players', 'PlayerController');
    Route::get('playerindex','UserController@playerindex');
    Route::get('teams/{team}/players', 'TeamController@players');
    Route::get("matches", "MatchController@index");
    Route::get("matches/round16", "MatchController@round16");
    Route::post("matches/{match}/scores", "MatchController@updateScores");

});
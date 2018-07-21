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

    Route::post('details', 'UserController@details');


});


/*Route::get('playerindex','UserController@playerindex');
Route::post('register/team','TeamController@store');
Route::post('register/player','UserController@register_player');*/



/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware' => 'auth:api', 'as' => 'api.', 'namespace' => 'Api'], function() {
    Route::resource('teams', 'TeamController');
    Route::resource('players', 'PlayerController');

    Route::get('teams/{team}/players', 'TeamController@players');
});
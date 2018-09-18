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
Route::group(['middleware' => 'api'], function() {
	Route::post('/repl', 'ApiController@repl')->name('repl');
	Route::post('/scenario', 'ApiController@scenario')->name('scenario');
	Route::post('/log', 'ApiController@log')->name('log');
	Route::post('/bot', 'ApiController@bot')->name('bot');
	Route::post('/user', 'ApiController@bot')->name('user');
});

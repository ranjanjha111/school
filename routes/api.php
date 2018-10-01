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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

/*
 * Routes for front end user
 */
Route::group(['namespace' => 'API'], function() {
    Route::post('login', 'UserController@login');
});

/*
 * Authenticated Routes for authenticated user only
 */
Route::group(['namespace' => 'API', 'middleware' => ['auth:api']], function() {
    Route::post('profile', 'UserController@profile');
    Route::post('logout', 'UserController@logout');

});
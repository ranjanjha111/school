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

Route::post('login', 'API\UserController@login');

/*
 * Authenticated routes
 */
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('user/profile', 'API\UserController@profile');
    Route::post('logout', 'API\UserController@logout');


});

Route::post('glogin', 'API\UserController@glogin');

Route::group(['middleware' => 'auth:guardian-api'], function() {
    Route::post('guardian/profile', 'API\UserController@profile');

});

/*
 * Routes for front end user
 */
//Route::group(['namespace' => 'API'], function() {
//    Route::post('login', 'UserController@login');
//});

/*
 * Authenticated Routes for authenticated user only
 */
//Route::group(['namespace' => 'API', 'middleware' => ['auth:api']], function() {
//    Route::post('profile', 'UserController@profile');
//    Route::post('logout', 'UserController@logout');
//
//});
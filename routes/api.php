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

Route::get('/threads','ThreadsController@apiindex');


//group route
Route::group(['prefix'=>'threads'], function ()
{
    Route::get('/{channel}/{thread}/' , 'ThreadsController@apishow');
//    Route::post('/{channel}/{thread}/replies', 'RepliesController@store');

});

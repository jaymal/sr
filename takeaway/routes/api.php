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

//Use nouns as resource names (e.g. don’t use verbs in URLs). :(
Route::post('/sendEmail', 'Api\SendEmailController@create');
Route::get('/show', 'Api\SendEmailController@show');

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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', 'HomeController@create')->name('index');
Route::get('/history', 'HomeController@index')->name('hisory.list');
Route::post('/history', 'HomeController@store')->name('history.save');
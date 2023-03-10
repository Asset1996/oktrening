<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'cart'], function() {
    Route::get('show', 'CartController@show');
    Route::post('add', 'CartController@add');
    Route::patch('update', 'CartController@update');
    Route::delete('delete/{slug}', 'CartController@delete');
    Route::delete('clear', 'CartController@clear');
});

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

Route::group(['prefix' => 'orders'], function() {
    Route::post('confirm-order', 'OrdersController@confirm');
    Route::get('list', 'OrdersController@list')->middleware('auth:sanctum');
});

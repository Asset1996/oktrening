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

Route::group(['prefix' => 'products'], function() {
    Route::resource('product', 'ProductController');

    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::resource('attribute', 'AttributeController');

        Route::post('attribute-set-value', 'AttributeValueController@set');
        Route::delete('attribute-unset-value', 'AttributeValueController@unset');
    });

});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\System\Http\Controllers\SystemController;

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

Route::group(['prefix' => 'system'], function() {
    Route::post('/login', 'SystemController@index');

    Route::middleware('auth:sanctum')->get('/test', function (Request $request) {
        print_r(\Auth::user());
        exit();
    });
});

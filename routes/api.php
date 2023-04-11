<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScoreController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::get('get', [AuthController::class, 'get']);
        Route::post('logout', [AuthController::class, 'logout']);


    });

});
Route::group(['middleware' => 'auth:sanctum'], function () {
Route::post('/score', [ScoreController::class, 'store']);
Route::get('/score/getTopList', [ScoreController::class, 'getTopList']);
Route::get('/score/around', [ScoreController::class, 'getScoresAroundUser']);
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Backend\AppController;

Route::group(['prefix' => 'app', 'middleware' => 'auth:admin'], function () {
    Route::get('/', [AppController::class, 'index']);
    Route::post('/', [AppController::class, 'store']);
    Route::get('/{id?}/detail', [AppController::class, 'detail']);
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SettingController;

Route:: group(['prefix' => 'setting', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/role', [SettingController::class, 'indexRole']);
    Route::get('/permission', [SettingController::class, 'indexPermission']);
    Route::group(['prefix' => 'flip'], function () {
        Route::get('/', [SettingController::class, 'indexFlip']);
        Route::post('/', [SettingController::class, 'storeFlip']);
        Route::delete('/{id?}/delete', [SettingController::class, 'deleteFlip']);
    });
});
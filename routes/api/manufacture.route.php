<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ManufactureController;

Route:: group(['prefix' => 'manufacture', 'middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'material'], function () {
        Route::get('/', [ManufactureController::class, 'indexMaterial']);
        Route::post('/', [ManufactureController::class, 'storeMaterial']);
    });
});
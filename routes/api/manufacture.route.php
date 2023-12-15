<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ManufactureController;

Route:: group(['prefix' => 'manufacture', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/get-semi-finished-material/{type}', [ManufactureController::class, 'getSemiFinishedMaterial']);

    Route::group(['prefix' => 'material'], function () {
        Route::get('/', [ManufactureController::class, 'indexMaterial']);
        Route::post('/', [ManufactureController::class, 'storeMaterial']);
    });

    Route::group(['prefix' => 'semi-finished-material'], function () {
        Route::get('/', [ManufactureController::class, 'indexSemiFinishedMaterial']);
        Route::post('/', [ManufactureController::class, 'storeSemiFinishedMaterial']);
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [ManufactureController::class, 'indexProduct']);
        Route::post('/', [ManufactureController::class, 'storeProduct']);
        Route::get('/{id}/detail', [ManufactureController::class, 'detailProduct']);
        Route::get('/{id}/approve', [ManufactureController::class, 'approveProduct']);
    });
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PurchaseController;

Route:: group(['prefix' => 'purchase', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', [PurchaseController::class, 'store']);
    Route::get('/', [PurchaseController::class, 'index']);
    Route::get('/{id}/detail', [PurchaseController::class, 'detail']);

    Route::group(['prefix' => 'supplier'], function () {
        Route::post('/', [PurchaseController::class, 'storeSupplier']);
        Route::get('/', [PurchaseController::class, 'indexSupplier']);
        Route::get('/{id}/detail', [PurchaseController::class, 'detailSupplier']);
    });
});
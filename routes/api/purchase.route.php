<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PurchaseController;

Route:: group(['prefix' => 'purchase', 'middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'supplier'], function () {
        Route::post('/', [PurchaseController::class, 'storeSupplier']);
        Route::get('/', [PurchaseController::class, 'indexSupplier']);
        Route::get('/{id}/detail', [PurchaseController::class, 'detailSupplier']);
    });

    Route::get('/get-product-material/{type}', [PurchaseController::class, 'getProductMaterial']);
    Route::post('/', [PurchaseController::class, 'store']);
});
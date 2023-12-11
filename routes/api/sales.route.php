<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SalesController;

Route:: group(['prefix' => 'sales', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', [SalesController::class, 'store']);
    Route::get('/', [SalesController::class, 'index']);

    Route::group(['prefix' => 'customer'], function () {
        Route::post('/', [SalesController::class, 'storeCustomer']);
        Route::get('/', [SalesController::class, 'indexCustomer']);
        Route::get('/{id}/detail', [SalesController::class, 'detailCustomer']);
    });
});
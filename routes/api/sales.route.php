<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SalesController;

Route:: group(['prefix' => 'sales', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', [SalesController::class, 'store']);
    Route::get('/', [SalesController::class, 'index']);
    Route::get('/summarize-count', [SalesController::class, 'summarizeCount']);
    Route::get('/{id}/detail', [SalesController::class, 'detail']);

    Route::group(['prefix' => 'customer'], function () {
        Route::post('/', [SalesController::class, 'storeCustomer']);
        Route::get('/', [SalesController::class, 'indexCustomer']);
        Route::get('/{id}/detail', [SalesController::class, 'detailCustomer']);
    });
    Route::group(['prefix' => 'payment'], function () {
        Route::post('/', [SalesController::class, 'storePayment']);
        Route::get('/{id}/detail', [SalesController::class, 'detailPayment']);
        Route::delete('/{id}/{salesId}/delete', [SalesController::class, 'deletePayment']);
    });
});
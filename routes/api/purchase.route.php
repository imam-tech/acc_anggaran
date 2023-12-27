<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PurchaseController;

Route:: group(['prefix' => 'purchase', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', [PurchaseController::class, 'store']);
    Route::get('/', [PurchaseController::class, 'index']);
    Route::get('/{id}/detail', [PurchaseController::class, 'detail']);
    Route::delete('/{id}/delete', [PurchaseController::class, 'delete']);
    Route::get('/summarize-count', [PurchaseController::class, 'summarizeCount']);

    Route::group(['prefix' => 'payment'], function () {
        Route::post('/', [PurchaseController::class, 'storePayment']);
        Route::get('/{id}/detail', [PurchaseController::class, 'detailPayment']);
        Route::delete('/{id}/{purchaseId}/delete', [PurchaseController::class, 'deletePayment']);
        Route::get('/{id}/approve', [PurchaseController::class, 'approvePayment']);
    });
});
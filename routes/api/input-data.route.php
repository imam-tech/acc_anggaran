<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InputData\CashAndBankController;
use App\Http\Controllers\Api\InputData\SalesController;
use App\Http\Controllers\Api\InputData\PurchaseController;
use App\Http\Controllers\Api\InputData\JournalController;

Route:: group(['prefix' => 'input-data', 'middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'cash-and-bank'], function () {
        Route::post('/', [CashAndBankController::class, 'store']);
        Route::get('/', [CashAndBankController::class, 'index']);
        Route::get('/{id}/detail', [CashAndBankController::class, 'detail']);
    });
    Route:: group(['prefix' => 'sales'], function () {
        Route::post('/', [SalesController::class, 'store']);
        Route::get('/', [SalesController::class, 'index']);
        Route::get('/summarize-count', [SalesController::class, 'summarizeCount']);
        Route::get('/{id}/detail', [SalesController::class, 'detail']);
        Route::delete('/{id}/delete', [SalesController::class, 'delete']);

        Route::group(['prefix' => 'payment'], function () {
            Route::post('/', [SalesController::class, 'storePayment']);
            Route::get('/{id}/detail', [SalesController::class, 'detailPayment']);
            Route::delete('/{id}/{salesId}/delete', [SalesController::class, 'deletePayment']);
            Route::get('/{id}/approve', [SalesController::class, 'approvePayment']);
        });
    });
    Route:: group(['prefix' => 'purchase'], function () {
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

    Route:: group(['prefix' => 'journal'], function () {
        Route::get('/', [JournalController::class, 'index']);
        Route::post('/', [JournalController::class, 'store']);
        Route::get('/{id}/detail', [JournalController::class, 'detail']);
        Route::delete('/{id}/delete', [JournalController::class, 'delete']);
        Route::post('/{id}/approval', [JournalController::class, 'approval']);
    });
});
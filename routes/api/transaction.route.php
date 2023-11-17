<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransactionController;

Route:: group(['prefix' => 'transaction', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [TransactionController::class, 'index']);
    Route::post('/', [TransactionController::class, 'store']);
    Route::get('/{id?}/detail', [TransactionController::class, 'detail']);
    Route::get('/{id?}/{status?}/approval/{itemId}', [TransactionController::class, 'approval']);
    Route::get('/{id?}/publish', [TransactionController::class, 'publish']);
    Route::post('/{id?}/set-tax/{item_id}', [TransactionController::class, 'setTax']);
    Route::post('/{id?}/set-coa/{item_id}', [TransactionController::class, 'setCoa']);
    Route::get('/{id?}/forced-status', [TransactionController::class, 'forcedStatus']);
});
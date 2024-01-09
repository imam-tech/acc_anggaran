<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransactionController;

Route:: group(['prefix' => 'transaction', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [TransactionController::class, 'index']);
    Route::post('/', [TransactionController::class, 'store']);
    Route::get('/{id?}/detail', [TransactionController::class, 'detail']);
    Route::get('/{id?}/reject', [TransactionController::class, 'reject']);
    Route::delete('/{id?}/delete', [TransactionController::class, 'delete']);
    Route::get('/{id?}/{status?}/approval/{itemId}', [TransactionController::class, 'approval']);
    Route::get('/{id?}/publish', [TransactionController::class, 'publish']);
    Route::post('/{id?}/set-tax/{item_id}', [TransactionController::class, 'setTax']);
    Route::post('/{id?}/set-coa/{item_id}', [TransactionController::class, 'setCoa']);
    Route::get('/{id?}/forced-status', [TransactionController::class, 'forcedStatus']);
    Route::post('/{id?}/set-method/', [TransactionController::class, 'setMethod']);
    Route::post('/upload-image', [TransactionController::class, 'uploadImage']);
});
Route::post('/transaction/callback-flip', [TransactionController::class, 'callbackFlip']);
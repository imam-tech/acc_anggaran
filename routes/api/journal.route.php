<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JournalController;

Route:: group(['prefix' => 'journal', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [JournalController::class, 'index']);
    Route::post('/', [JournalController::class, 'store']);
    Route::get('/{id}/detail', [JournalController::class, 'detail']);
    Route::delete('/{id}/delete', [JournalController::class, 'delete']);
    Route::post('/{id}/approval', [JournalController::class, 'approval']);

    Route::group(['prefix' => 'report'], function() {
        Route::get('/balance-profit', [JournalController::class, 'balanceProfit']);
        Route::get('/cashflow', [JournalController::class, 'cashflow']);
        Route::get('/cashflow-initial-balance', [JournalController::class, 'cashflowInitial']);
        Route::get('/journal', [JournalController::class, 'journal']);
        Route::get('/general-ledger', [JournalController::class, 'generalLedger']);
    });
});
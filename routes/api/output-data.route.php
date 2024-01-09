<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OutputDataController;

Route:: group(['prefix' => 'output-data', 'middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'report'], function () {
        Route::get('/balance-profit', [OutputDataController::class, 'balanceProfit']);
        Route::get('/cashflow', [OutputDataController::class, 'cashflow']);
        Route::get('/cashflow-initial-balance', [OutputDataController::class, 'cashflowInitial']);
        Route::get('/journal', [OutputDataController::class, 'journal']);
        Route::get('/general-ledger', [OutputDataController::class, 'generalLedger']);
    });
});
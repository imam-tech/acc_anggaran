<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CashAndBankController;

Route:: group(['prefix' => 'cash-and-bank', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', [CashAndBankController::class, 'store']);
    Route::get('/', [CashAndBankController::class, 'index']);
    Route::get('/{id}/detail', [CashAndBankController::class, 'detail']);
});
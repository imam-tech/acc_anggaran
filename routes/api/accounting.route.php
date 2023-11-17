<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AccountingController;

Route:: group(['prefix' => 'accounting', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/index-role', [AccountingController::class, 'indexRole']);
    Route::post('/change-role', [AccountingController::class, 'changeRole']);
});
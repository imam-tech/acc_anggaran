<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JournalController;

Route:: group(['prefix' => 'journal', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [JournalController::class, 'index']);
    Route::get('/{id}/detail', [JournalController::class, 'detail']);
    Route::post('/{id}/approval', [JournalController::class, 'approval']);
});
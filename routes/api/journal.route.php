<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JournalController;

Route:: group(['prefix' => 'journal', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [JournalController::class, 'index']);
    Route::post('/', [JournalController::class, 'store']);
    Route::get('/{id}/detail', [JournalController::class, 'detail']);
    Route::delete('/{id}/delete', [JournalController::class, 'delete']);
    Route::post('/{id}/approval', [JournalController::class, 'approval']);
});
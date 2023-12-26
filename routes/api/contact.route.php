<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactController;

Route:: group(['prefix' => 'contact', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', [ContactController::class, 'store']);
    Route::get('/', [ContactController::class, 'index']);
    Route::get('/{id}/detail', [ContactController::class, 'detail']);
});
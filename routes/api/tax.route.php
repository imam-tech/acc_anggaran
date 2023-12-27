<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaxController;

Route:: group(['prefix' => 'tax', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [TaxController::class, 'index']);
    Route::post('/', [TaxController::class, 'store']);
    Route::delete('/{id?}/delete', [TaxController::class, 'delete']);
    Route::get('/{id?}/archive', [TaxController::class, 'archive']);
});
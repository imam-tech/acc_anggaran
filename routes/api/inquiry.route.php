<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InquiryController;

Route:: group(['prefix' => 'inquiry', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [InquiryController::class, 'index']);
    Route::post('/', [InquiryController::class, 'store']);
    Route::delete('/{id?}/delete', [InquiryController::class, 'delete']);
});
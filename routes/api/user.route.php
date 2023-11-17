<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route:: group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/not-admin', [UserController::class, 'notAdmin']);
    Route::post('/', [UserController::class, 'store']);
    Route::delete('/{id?}/delete', [UserController::class, 'delete']);
    Route::get('/not-staff', [UserController::class, 'notStaff']);
});
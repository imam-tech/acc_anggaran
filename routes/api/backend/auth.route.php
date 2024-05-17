<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'backendLogin']);
    Route::get('logout', [AuthController::class, 'backendLogout'])->middleware(['auth:admin']);
});

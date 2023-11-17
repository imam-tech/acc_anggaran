<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CompanyController;

Route:: group(['prefix' => 'company', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [CompanyController::class, 'index']);
    Route::post('/', [CompanyController::class, 'store']);
    Route::delete('/{id?}/delete', [CompanyController::class, 'delete']);
    Route::get('/{id?}/detail', [CompanyController::class, 'detail']);
    Route::post('/admin-approval', [CompanyController::class, 'adminApproval']);
    Route::post('/{id?}/push-plugin', [CompanyController::class, 'pushPlugin']);
});
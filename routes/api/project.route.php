<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;

Route:: group(['prefix' => 'project', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::post('/', [ProjectController::class, 'store']);
    Route::delete('/{id?}/delete', [ProjectController::class, 'delete']);
    Route::get('/{id?}/detail', [ProjectController::class, 'detail']);
    Route::post('/assign-user-to-project', [ProjectController::class, 'assignUserToProject']);
    Route::delete('/{id?}/unassign', [ProjectController::class, 'unassign']);
});
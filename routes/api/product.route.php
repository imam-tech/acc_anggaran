<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route:: group(['prefix' => 'product', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}/detail', [ProductController::class, 'detail']);
    Route::delete('/{id}/delete', [ProductController::class, 'delete']);

    Route::group(['prefix' => 'unit'], function () {
        Route::post('/', [ProductController::class, 'storeUnit']);
        Route::get('/', [ProductController::class, 'indexUnit']);
        Route::delete('/{id}/delete', [ProductController::class, 'deleteUnit']);
    });

    Route::group(['prefix' => 'category'], function () {
        Route::post('/', [ProductController::class, 'storeCategory']);
        Route::get('/', [ProductController::class, 'indexCategory']);
        Route::delete('/{id}/delete', [ProductController::class, 'deleteCategory']);
    });
});
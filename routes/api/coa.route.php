<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CoaController;

Route:: group(['prefix' => 'coa', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [CoaController::class, 'index']);
    Route::post('/', [CoaController::class, 'store']);
    Route::delete('/{id?}/delete', [CoaController::class, 'delete']);
    Route::get('/posting', [CoaController::class, 'indexPosting']);
    Route::get('/cashflow', [CoaController::class, 'indexCashflow']);
    Route::get('/category-list', [CoaController::class, 'indexCategoryList']);
    Route::get('/{categoryId}/detail-all', [CoaController::class, 'detailAllCoa']);
    Route::post('/journal-items', [CoaController::class, 'journalItemsCategory']);

    Route::group(['prefix' => 'category'], function (){
        Route::get('/', [CoaController::class, 'indexCategory']);
        Route::get('/{id}/detail', [CoaController::class, 'detailCategory']);
    });
});
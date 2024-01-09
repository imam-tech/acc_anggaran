<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MasterData\ContactController;
use App\Http\Controllers\Api\MasterData\ProductController;
use App\Http\Controllers\Api\MasterData\TaxController;
use App\Http\Controllers\Api\MasterData\CoaController;
use App\Http\Controllers\Api\MasterData\IndexController;

Route:: group(['prefix' => 'master-data', 'middleware' => 'auth:sanctum'], function () {
    Route:: group(['prefix' => 'contact'], function () {
        Route::post('/', [ContactController::class, 'store']);
        Route::get('/', [ContactController::class, 'index']);
        Route::get('/{id}/detail', [ContactController::class, 'detail']);
        Route::get('/{id}/archive', [ContactController::class, 'archive']);
    });

    Route:: group(['prefix' => 'product'], function () {
        Route::post('/', [ProductController::class, 'store']);
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{id}/detail', [ProductController::class, 'detail']);
        Route::delete('/{id}/delete', [ProductController::class, 'delete']);
        Route::get('/{id}/archive', [ProductController::class, 'archive']);


        Route::group(['prefix' => 'category'], function () {
            Route::post('/', [ProductController::class, 'storeCategory']);
            Route::get('/', [ProductController::class, 'indexCategory']);
            Route::delete('/{id}/delete', [ProductController::class, 'deleteCategory']);
            Route::get('/{id}/archive', [ProductController::class, 'archiveCategory']);
        });
    });

    Route::group(['prefix' => 'unit'], function () {
        Route::post('/', [IndexController::class, 'storeUnit']);
        Route::get('/', [IndexController::class, 'indexUnit']);
        Route::delete('/{id}/delete', [IndexController::class, 'deleteUnit']);
        Route::get('/{id}/archive', [IndexController::class, 'archiveUnit']);
    });

    Route::group(['prefix' => 'tag'], function () {
        Route::post('/', [IndexController::class, 'storeTag']);
        Route::get('/', [IndexController::class, 'indexTag']);
        Route::delete('/{id}/delete', [IndexController::class, 'deleteTag']);
        Route::get('/{id}/archive', [IndexController::class, 'archiveTag']);
    });

    Route::group(['prefix' => 'payment-method'], function () {
        Route::get('/', [IndexController::class, 'indexPM']);
        Route::post('/', [IndexController::class, 'storePM']);
        Route::delete('/{id?}/delete', [IndexController::class, 'deletePM']);
        Route::get('/{id?}/archive', [IndexController::class, 'archivePM']);
    });

    Route:: group(['prefix' => 'taxes', 'middleware' => 'auth:sanctum'], function () {
        Route::get('/', [TaxController::class, 'index']);
        Route::post('/', [TaxController::class, 'store']);
        Route::delete('/{id?}/delete', [TaxController::class, 'delete']);
        Route::get('/{id?}/archive', [TaxController::class, 'archive']);
    });

    Route:: group(['prefix' => 'coa', 'middleware' => 'auth:sanctum'], function () {
        Route::get('/', [CoaController::class, 'index']);
        Route::get('/by-company', [CoaController::class, 'indexByCompany']);
        Route::post('/', [CoaController::class, 'store']);
        Route::post('/upload-bulk', [CoaController::class, 'uploadBulk']);
        Route::delete('/{id?}/delete', [CoaController::class, 'delete']);
        Route::get('/{id?}/set-initial-balance/{amount}', [CoaController::class, 'setInitialBalance']);

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
});
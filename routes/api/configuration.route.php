<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Configuration\CompanyController;
use App\Http\Controllers\Api\Configuration\UserController;
use App\Http\Controllers\Api\Configuration\SettingController;

Route:: group(['prefix' => 'configuration'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route:: group(['prefix' => 'company'], function () {
            Route::get('/', [CompanyController::class, 'index']);
            Route::post('/', [CompanyController::class, 'store']);
            Route::delete('/{id?}/delete', [CompanyController::class, 'delete']);
            Route::get('/{id?}/detail', [CompanyController::class, 'detail']);
            Route::post('/admin-approval', [CompanyController::class, 'adminApproval']);
            Route::post('/{id?}/push-plugin', [CompanyController::class, 'pushPlugin']);
            Route::get('/{id?}/change-setting-flip/{settingId?}', [CompanyController::class, 'changeSettingFlip']);
        });

        Route:: group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::delete('/{id?}/delete', [UserController::class, 'delete']);
            Route::get('/not-staff', [UserController::class, 'notStaff']);
            Route::post('/change-password', [UserController::class, 'changePassword']);
        });

        Route::get('/role', [SettingController::class, 'indexRole']);
        Route::get('/permission', [SettingController::class, 'indexPermission']);
        Route::group(['prefix' => 'flip'], function () {
            Route::get('/', [SettingController::class, 'indexFlip']);
            Route::post('/', [SettingController::class, 'storeFlip']);
            Route::delete('/{id?}/delete', [SettingController::class, 'deleteFlip']);
        });
    });
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::group(['prefix' => 'view'], function () {
            Route::get('/', [SettingController::class, 'indexView']);
            Route::post('/', [SettingController::class, 'storeVIew']);
        });
        Route::post('/set-general', [SettingController::class, 'setGeneral']);
    });
});
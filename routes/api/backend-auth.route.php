<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::group(['prefix' => 'backend'], function () {
    foreach (glob("../routes/api/backend/*.route.php") as $filename) {
        include $filename;
    }
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect('/app');
});
Route::get('/app/{any?}', [AppController::class, 'index'])->where('any', '.*');
Route::get('/auth/{any?}', [AppController::class, 'index'])->where('any', '.*');
Route::get('/print/balance-sheet', [AppController::class, 'printBalanceSheet']);
Route::get('/print/profit-lost', [AppController::class, 'printProfitLose']);
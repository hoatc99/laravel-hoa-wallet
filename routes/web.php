<?php

use App\Http\Controllers\Api\WalletApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::get('/table', [HomeController::class, 'table']);
    Route::get('/wallets/{wallet}/histories', [WalletController::class, 'histories'])->name('wallets.histories');
    Route::get('/wallets/{wallet}/statistics', [WalletController::class, 'statistics'])->name('wallets.statistics');
    Route::get('/wallets/sort', [WalletController::class, 'sort'])->name('wallets.sort');
    Route::resource('wallets.balances', BalanceController::class)->shallow();
    Route::resource('wallets.savings', SavingController::class)->shallow();
    Route::resource('wallets', WalletController::class);

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

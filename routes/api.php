<?php

use App\Http\Controllers\Api\WalletApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('web')->group(function () {
    Route::controller(WalletApiController::class)->prefix('wallets')->group(function () {
        Route::post('/update-order', 'updateOrder');
        Route::get('/{wallet}/getDataHistory', 'getDataHistory');
        Route::get('/{wallet}/getDataChart', 'getDataChart');
        Route::get('/{wallet}/getStatisticsByYear', 'getStatisticsByYear');
    });
});

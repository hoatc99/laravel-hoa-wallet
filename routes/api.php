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
    Route::post('/wallets/update-order', [WalletApiController::class, 'updateOrder']);
    Route::get('/table/{wallet}', [WalletApiController::class, 'getDataForTable']);
    Route::get('/chart/{wallet}', [WalletApiController::class, 'getDataForChart']);
});

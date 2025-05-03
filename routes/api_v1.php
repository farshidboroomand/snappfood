<?php

use Illuminate\Support\Facades\Route;
use Modules\V1\Users\Controllers\API\UserController;
use Modules\V1\Wallets\Controllers\API\WalletController;

Route::prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'userList']);
        Route::post('/', [UserController::class, 'createUser']);
    });

    Route::prefix('wallets')->group(function () {
        Route::get('/{wallet_id}', [WalletController::class, 'getUserWallet']);
    });
});

<?php

use Illuminate\Support\Facades\Route;
use Modules\V1\Users\Controllers\API\UserController;
use Modules\V1\Users\Controllers\API\UserProfileController;
use Modules\V1\Wallets\Controllers\API\WalletController;
use Modules\V1\Wallets\Controllers\API\WithdrawalController;

Route::prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'userList']);
        Route::post('/', [UserController::class, 'createUser']);

        Route::patch('/{user_id}/profiles/{profile_id}', [UserProfileController::class, 'updateUserProfile']);
    });

    Route::prefix('wallets')->group(function () {
        Route::get('/{wallet_id}', [WalletController::class, 'getUserWallet']);

        Route::prefix('{wallet_id}/withdrawals')->group(function () {
            Route::post('/sheba', [WithdrawalController::class, 'createWithdrawalRequest']);
        });
    });
});

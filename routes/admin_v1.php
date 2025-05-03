<?php

use Illuminate\Support\Facades\Route;
use Modules\V1\Wallets\Controllers\Admin\AdminWithdrawalController;

Route::prefix('admin/v1')->group(function () {
    Route::get('/withdrawals', [AdminWithdrawalController::class, 'getAllRequestedWithdrawals']);
    Route::post('/withdrawals/{withdrawal_id}', [AdminWithdrawalController::class, 'changeRequestedWithdrawalStatus']);
});

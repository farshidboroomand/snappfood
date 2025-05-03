<?php

use Illuminate\Support\Facades\Route;
use Modules\V1\Users\Controllers\API\UserController;

Route::prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::post('/', [UserController::class, 'createUser']);
    });
});

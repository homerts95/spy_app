<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpyController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/token', [AuthController::class, 'token'])->name('auth.token');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'revokeCurrentToken'])->name('auth.logout');

    Route::post('/spies', [SpyController::class, 'store']);
});

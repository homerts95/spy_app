<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/token', [AuthController::class, 'token'])->name('auth.token');

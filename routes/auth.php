<?php

use App\Http\Controllers\Auth\AuthController;

use Illuminate\Support\Facades\Route;

// --------------------------------------------------------------------------
// Login & Logout
// --------------------------------------------------------------------------
Route::get('/login', [AuthController::class, 'index'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

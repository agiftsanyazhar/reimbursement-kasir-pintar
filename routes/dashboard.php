<?php

use App\Http\Controllers\Dashboard\{
    ReimbursmentController,
    UserController,
};

use Illuminate\Support\Facades\Route;

Route::prefix('reimbursment')->name('reimbursment.')->group(function () {
    Route::get('/', [ReimbursmentController::class, 'index'])->name('index');
    Route::post('/store', [ReimbursmentController::class, 'store'])->name('store');
    Route::post('/update', [ReimbursmentController::class, 'update'])->name('update');
    Route::get('/update/status/{id}/approve', [ReimbursmentController::class, 'approve'])->name('update-status.approve');
    Route::get('/update/status/{id}/reject', [ReimbursmentController::class, 'reject'])->name('update-status.reject');
    Route::get('/destroy/{id}', [ReimbursmentController::class, 'destroy'])->name('destroy');
});

Route::group(['middleware' => 'is.direktur'], function () {
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::post('/update', [UserController::class, 'update'])->name('update');
        Route::get('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
    });
});

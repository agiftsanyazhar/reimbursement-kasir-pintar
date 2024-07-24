<?php

use App\Http\Controllers\Dashboard\ReimbursementController;

use Illuminate\Support\Facades\Route;

Route::prefix('reimbursement')->name('reimbursement.')->group(function () {
    Route::get('/', [ReimbursementController::class, 'index'])->name('index');
});

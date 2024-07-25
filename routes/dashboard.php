<?php

use App\Http\Controllers\Dashboard\ReimbursmentController;

use Illuminate\Support\Facades\Route;

Route::prefix('reimbursment')->name('reimbursment.')->group(function () {
    Route::get('/', [ReimbursmentController::class, 'index'])->name('index');
    // Route::get('/edit/{id}', [AboutMeController::class, 'edit'])->name('edit');
    // Route::post('/update/{id}', [AboutMeController::class, 'update'])->name('update');
});

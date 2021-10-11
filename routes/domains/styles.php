<?php
use App\Http\Controllers\Styles\InternalStylesController;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/internal-styles/create', [InternalStylesController::class, 'create'])->name('style.internal.create');
    Route::get('/internal-styles/edit/{style}', [InternalStylesController::class, 'edit'])->name('style.internal.edit');
    Route::get('/internal-styles', [InternalStylesController::class, 'index'])->name('style.internal.index');
    Route::post('/internal-styles', [InternalStylesController::class, 'store'])->name('style.internal.store');
});

<?php
use App\Http\Controllers\Invoices\InvoicesController;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/invoices/create', [InvoicesController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [InvoicesController::class, 'store'])->name('invoice.store');
    Route::get('/invoices/{invoice}', [InvoicesController::class, 'show'])->name('invoices.show');
});

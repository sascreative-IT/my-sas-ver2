<?php
use App\Http\Controllers\Factory\FactoryOrderController;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/factory', [FactoryOrderController::class, 'index'])->name('factory.orders.index');
    Route::get('/factory/create', [FactoryOrderController::class, 'create'])->name('factory.orders.create');
    Route::post('/factory/order', [FactoryOrderController::class, 'store'])->name('factory.orders.store');
    Route::get('/factory/order/show', [FactoryOrderController::class, 'show'])->name('factory.orders.show');
});

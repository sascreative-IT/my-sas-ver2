<?php
use App\Http\Controllers\Inventory\InventoryAdjustmentController;
use App\Http\Controllers\Inventory\InventoryController;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/{materialInventory}/details', [InventoryController::class, 'show'])->name('inventory.show');
    Route::post('/inventory/{inventory}/adjust', [InventoryAdjustmentController::class, 'store'])->name('inventory.adjust');
});

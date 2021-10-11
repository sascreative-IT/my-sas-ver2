<?php
declare(strict_types=1);

namespace App\Domains\Inventory\Actions;

use App\Models\InventoryIn;
use App\Models\MaterialInventory;

class CalculateAggregationForInventoryItem
{
    public function execute(MaterialInventory $inventory)
    {
        $totalStockAdded = InventoryIn::query()
            ->where('material_inventory_id', $inventory->id)
            ->sum('quantity');

        // -- Note : Some part are still to be build
        // $totalUsedInventory (Query InventoryOut)
        // $totalAllocatedStock (orders that has not been started yet)

        $availableStock = $totalStockAdded; // $availableStock = $totalStockAdded - $totalUsedInventory
        $allocatedStock = 0; //
        $usableStock = $availableStock - $allocatedStock;

        $inventory->available_quantity = $availableStock;
        $inventory->allocated_quantity = $allocatedStock;
        $inventory->usable_quantity = $usableStock;
        $inventory->save();
    }
}

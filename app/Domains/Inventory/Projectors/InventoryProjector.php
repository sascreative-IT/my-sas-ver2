<?php

namespace App\Domains\Inventory\Projectors;

use App\Domains\Inventory\Events\Internal\InventoryMaterialAdded;
use App\Domains\Inventory\Events\Internal\StockAdded;
use App\Models\InventoryLog;
use App\Models\MaterialInventory;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

class InventoryProjector extends Projector
{
    public function onInventoryMaterialAdded(InventoryMaterialAdded $inventoryMaterialAdded)
    {
        MaterialInventory::create([
            'aggregate_id' => $inventoryMaterialAdded->aggregateRootUuid(),
            'material_variation_id' => $inventoryMaterialAdded->variationId,
            'factory_id' => $inventoryMaterialAdded->factoryId,
            'supplier_id' => $inventoryMaterialAdded->supplierId,
            'unit' => 'm',
            'available_quantity' => 0,
            'allocated_quantity' => 0,
            'usable_quantity' => 0,
            'created_at' => $inventoryMaterialAdded->createdAt(),
            'updated_at' => $inventoryMaterialAdded->createdAt(),
        ]);
    }

    public function onStockAdded(StockAdded $stockAdded)
    {
        InventoryLog::create([
            'material_inventories_aggregate_id' => $stockAdded->aggregateRootUuid(),
            'unit' => $stockAdded->unit,
            'in' => $stockAdded->quantity,
            'balance' => $stockAdded->newBalance,
            'in_invoice_item_id' => $stockAdded->invoiceItemId,
            'in_unit_price' => $stockAdded->unitPrice,
            'in_unit_currency' => $stockAdded->currency,
            'created_at' => $stockAdded->createdAt(),
            'updated_at' => $stockAdded->createdAt(),
        ]);
    }
}

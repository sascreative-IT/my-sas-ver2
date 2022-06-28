<?php

namespace App\Domains\Inventory\Projectors;

use App\Domains\Inventory\Events\Internal\InventoryMaterialAdded;
use App\Domains\Inventory\Events\Internal\StockAdded;
use App\Domains\Inventory\Events\Internal\StockRemoved;
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
        $materialInventory = MaterialInventory::query()->where('aggregate_id', $stockAdded->aggregateRootUuid())->first();
        $materialInventory->update([
            'available_quantity' => $stockAdded->newBalance
        ]);

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

    public function onStockRemoved(StockRemoved $stockRemoved)
    {
        $materialInventory = MaterialInventory::query()->where('aggregate_id', $stockRemoved->aggregateRootUuid())->first();
        $materialInventory->update([
            'available_quantity' => ($materialInventory->available_quantity - $stockRemoved->quantity),
        ]);

        InventoryLog::create([
            'material_inventories_aggregate_id' => $stockRemoved->aggregateRootUuid(),
            'unit' => $stockRemoved->unit,
            'out' => $stockRemoved->quantity,
            'balance' => 100,
            'out_order_id' => $stockRemoved->outOrderId,
            'out_style_panel_id' => $stockRemoved->stylePanelId,
            'created_at' => $stockRemoved->createdAt(),
            'updated_at' => $stockRemoved->createdAt(),
        ]);
    }
}

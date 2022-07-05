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
            'action_taken_by' => $inventoryMaterialAdded->userId,
            'created_at' => $inventoryMaterialAdded->createdAt(),
            'updated_at' => $inventoryMaterialAdded->createdAt(),
        ]);
    }

    public function onStockAdded(StockAdded $stockAdded)
    {
        $materialInventory = MaterialInventory::query()->where('aggregate_id', $stockAdded->aggregateRootUuid())->first();

        $materialInventory->update([
            'available_quantity' => $materialInventory->available_quantity + $stockAdded->quantity
        ]);

        $balance = $stockAdded->quantity;
        $latestInventoryLog = $this->lastInventoryLog($stockAdded->aggregateRootUuid());
        if ($latestInventoryLog) {
            $balance += $latestInventoryLog->balance;
        }
        InventoryLog::create([
            'material_inventories_aggregate_id' => $stockAdded->aggregateRootUuid(),
            'unit' => $stockAdded->unit,
            'in' => $stockAdded->quantity,
            'balance' => $balance,
            'in_invoice_item_id' => $stockAdded->invoiceItemId,
            'in_unit_price' => $stockAdded->unitPrice,
            'in_unit_currency' => $stockAdded->currency,
            'action_taken_by' => $stockAdded->userId,
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

        $balance = 0;
        $latestInventoryLog = $this->lastInventoryLog($stockRemoved->aggregateRootUuid());
        if ($latestInventoryLog) {
            $balance = $latestInventoryLog->balance;
        }
        $balance = $balance - $stockRemoved->quantity;

        InventoryLog::create([
            'material_inventories_aggregate_id' => $stockRemoved->aggregateRootUuid(),
            'unit' => $stockRemoved->unit,
            'out' => $stockRemoved->quantity,
            'balance' => $balance,
            'out_order_id' => $stockRemoved->outOrderId,
            'out_style_panel_id' => $stockRemoved->stylePanelId,
            'action_taken_by' => $stockRemoved->userId,
            'created_at' => $stockRemoved->createdAt(),
            'updated_at' => $stockRemoved->createdAt(),
        ]);
    }

    private function lastInventoryLog(string $aggregateRootId): ?InventoryLog
    {
        return InventoryLog::query()
            ->where('material_inventories_aggregate_id', $aggregateRootId)
            ->latest()
            ->limit(1)
            ->first();
    }

    public function onStartingEventReplay()
    {
        MaterialInventory::truncate();
        InventoryLog::truncate();
    }
}

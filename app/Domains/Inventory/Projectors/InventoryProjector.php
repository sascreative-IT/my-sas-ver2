<?php

namespace App\Domains\Inventory\Projectors;

use App\Domains\Inventory\Events\Internal\InventoryMaterialAdded;
use App\Domains\Inventory\Events\Internal\StockAdded;
use App\Domains\Inventory\Events\Internal\StockAddedManually;
use App\Domains\Inventory\Events\Internal\StockRemoved;
use App\Domains\Inventory\Events\Internal\StockRemovedManually;
use App\Models\InventoryLog;
use App\Models\MaterialInventory;
use Illuminate\Database\Eloquent\Builder;
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
        $materialInventory = $this->getMaterialFromInventory($stockAdded->aggregateRootUuid());

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

    public function onStockAddedManually(StockAddedManually $stockAddedManually)
    {
        $materialInventory = $this->getMaterialFromInventory($stockAddedManually->aggregateRootUuid());

        $materialInventory->update([
            'available_quantity' => $materialInventory->available_quantity + $stockAddedManually->quantity
        ]);

        $balance = $stockAddedManually->quantity;
        $latestInventoryLog = $this->lastInventoryLog($stockAddedManually->aggregateRootUuid());
        if ($latestInventoryLog) {
            $balance += $latestInventoryLog->balance;
        }

        InventoryLog::create([
            'material_inventories_aggregate_id' => $stockAddedManually->aggregateRootUuid(),
            'unit' => $stockAddedManually->unit,
            'in' => $stockAddedManually->quantity,
            'balance' => $balance,
            'in_unit_price' => $stockAddedManually->unitPrice,
            'in_unit_currency' => $stockAddedManually->currency,
            'reason' => $stockAddedManually->reason,
            'action_taken_by' => $stockAddedManually->userId,
            'created_at' => $stockAddedManually->createdAt(),
            'updated_at' => $stockAddedManually->createdAt(),
        ]);
    }

    public function onStockRemoved(StockRemoved $stockRemoved)
    {
        $materialInventory = $this->getMaterialFromInventory($stockRemoved->aggregateRootUuid());

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

    public function onStockRemovedManually(StockRemovedManually $stockRemovedManually)
    {
        $materialInventory = $this->getMaterialFromInventory($stockRemovedManually->aggregateRootUuid());

        $materialInventory->update([
            'available_quantity' => ($materialInventory->available_quantity - $stockRemovedManually->quantity),
        ]);

        $balance = 0;
        $latestInventoryLog = $this->lastInventoryLog($stockRemovedManually->aggregateRootUuid());
        if ($latestInventoryLog) {
            $balance = $latestInventoryLog->balance;
        }
        $balance = $balance - $stockRemovedManually->quantity;

        InventoryLog::create([
            'material_inventories_aggregate_id' => $stockRemovedManually->aggregateRootUuid(),
            'unit' => $stockRemovedManually->unit,
            'out' => $stockRemovedManually->quantity,
            'balance' => $balance,
            'action_taken_by' => $stockRemovedManually->userId,
            'reason' => $stockRemovedManually->reason,
            'created_at' => $stockRemovedManually->createdAt(),
            'updated_at' => $stockRemovedManually->createdAt(),
        ]);
    }

    private function getMaterialFromInventory(string $aggregateRootId)
    {
        return MaterialInventory::query()->where('aggregate_id', $aggregateRootId)->first();
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

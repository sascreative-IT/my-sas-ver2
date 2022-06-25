<?php

namespace App\Domains\Inventory\Projectors;

use App\Domains\Inventory\Events\Internal\InventoryMaterialAdded;
use App\Models\MaterialInventory;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

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
}

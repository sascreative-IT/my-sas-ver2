<?php

namespace App\Domains\Inventory\Repositories;

use App\Models\MaterialInventory;

class InventoryRepository
{
    public function isMaterialExist(int $variationId, int $supplierId, int $factoryId): bool
    {
        return MaterialInventory::query()
            ->where('material_variation_id', $variationId)
            ->where('factory_id', $factoryId)
            ->where('supplier_id', $supplierId)
            ->exists();
    }

    public function getMaterial(int $variationId, int $supplierId, int $factoryId): ?MaterialInventory
    {
        return MaterialInventory::query()
            ->where('material_variation_id', $variationId)
            ->where('factory_id', $factoryId)
            ->where('supplier_id', $supplierId)
            ->get()
            ->first();
    }
}

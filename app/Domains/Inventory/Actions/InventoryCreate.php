<?php
declare(strict_types=1);

namespace App\Domains\Inventory\Actions;

use App\Models\Factory;
use App\Models\MaterialInventory;
use App\Models\MaterialVariation;
use App\Models\Supplier;
use App\Models\Unit;

class InventoryCreate
{
    public function execute(
        MaterialVariation $variation,
        Factory $factory,
        string $unit,
        Supplier $supplier
    ): MaterialInventory
    {
        return MaterialInventory::firstOrCreate(
            [
                'material_variation_id' => $variation->id,
                'factory_id' => $factory->id,
                'unit' => $unit,
                'supplier_id' => $supplier->id,
            ],
            [
                'available_quantity' => 0,
                'allocated_quantity' => 0,
                'usable_quantity' => 0,
            ]
        );
    }
}

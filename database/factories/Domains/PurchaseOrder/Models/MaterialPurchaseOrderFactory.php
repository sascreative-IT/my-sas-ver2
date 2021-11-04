<?php

namespace Database\Factories\Domains\PurchaseOrder\Models;

use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrderItem;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialPurchaseOrderFactory extends Factory
{
    protected $model = MaterialPurchaseOrder::class;


    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'factory_id' => \App\Models\Factory::factory(),
        ];
    }

    public function withItems(int $count = 1)
    {
        return $this->afterCreating(function (MaterialPurchaseOrder $materialPurchaseOrder) use ($count) {
            MaterialPurchaseOrderItem::factory()->count($count)->create([
                'material_purchase_order_id' => $materialPurchaseOrder->id,
            ]);
        });
    }
}

<?php

namespace Database\Factories\Domains\PurchaseOrder\Models;

use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrderItem;
use App\Models\MaterialVariation;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialPurchaseOrderItemFactory extends Factory
{
    protected $model = MaterialPurchaseOrderItem::class;


    public function definition(): array
    {
        return [
            'material_purchase_order_id' => MaterialPurchaseOrder::factory(),
            'material_variation_id' => MaterialVariation::factory(),
            'quantity' => rand(1,10),
            'unit' => 'm',
            'price' => $this->faker->randomDigit(),
            'currency' => 'NZD'

        ];
    }
}

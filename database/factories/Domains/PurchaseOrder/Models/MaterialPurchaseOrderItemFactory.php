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
        $quantity = rand(1,10);
        $unit_price = $this->faker->randomDigit();
        return [
            'material_purchase_order_id' => MaterialPurchaseOrder::factory(),
            'material_variation_id' => MaterialVariation::factory(),
            'quantity' => $quantity,
            'unit' => 'm',
            'unit_price' => $unit_price,
            'sub_total' => $unit_price * $quantity,
            'currency' => 'NZD'

        ];
    }
}

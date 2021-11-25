<?php

namespace Database\Factories\Domains\PurchaseOrder\Models;

use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
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
            'factory_id' => \App\Models\Factory::find(1),
            'approved_by_id' => User::factory(),
            'approved_at' => now()
        ];
    }
}

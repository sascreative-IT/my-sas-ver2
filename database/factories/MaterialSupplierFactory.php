<?php

namespace Database\Factories;

use App\Models\MaterialSupplier;
use App\Models\MaterialVariation;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialSupplierFactory extends Factory
{
    protected $model = MaterialSupplier::class;

    public function definition()
    {
        return [
            'variation_id'=> MaterialVariation::factory(),
            'supplier_id' => Supplier::factory(),
            'factory_id' => \App\Models\Factory::factory(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\MaterialInventory;
use App\Models\MaterialVariation;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MaterialInventoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MaterialInventory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $a = random_int(100, 1000);
        $al = random_int($a-($a/2), $a);
        $u = $a - $al;

        return [
            'aggregate_id' => Str::uuid()->toString() ,
            'material_variation_id' => MaterialVariation::factory()->create(),
//            'material_variation_id' => MaterialVariation::find(1),
            'factory_id' => \App\Models\Factory::factory()->create(),
            'supplier_id' => Supplier::factory(),
            'unit' => 'm',
            'available_quantity' => $a,
            'allocated_quantity' => $al,
            'usable_quantity' => $u,
        ];
    }
}

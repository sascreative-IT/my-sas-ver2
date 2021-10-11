<?php

namespace Database\Factories;

use App\Models\MaterialInventory;
use App\Models\MaterialVariation;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'material_variation_id' => MaterialVariation::factory()->create(),
//            'material_variation_id' => MaterialVariation::find(1),
            'factory_id' => \App\Models\Factory::factory()->create(),
            'unit' => 'm',
            'available_quantity' => $a,
            'allocated_quantity' => $al,
            'usable_quantity' => $u,
        ];
    }
}

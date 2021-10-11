<?php

namespace Database\Factories;

use App\Models\Colour;
use App\Models\Materials;
use App\Models\MaterialVariation;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialVariationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MaterialVariation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'material_id' => Materials::factory()->create(),
            'colour_id' => Colour::factory()->create(),
        ];
    }
}

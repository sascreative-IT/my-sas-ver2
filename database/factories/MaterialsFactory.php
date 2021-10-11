<?php

namespace Database\Factories;

use App\Models\Materials;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Materials::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Material ' . random_int(0, 100),
            'type' => 'fabric',
            'unit' => 'm',
            'fiber_content' => '',
        ];
    }
}

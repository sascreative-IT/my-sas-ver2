<?php

namespace Database\Factories;

use App\Models\StylePanel;
use Illuminate\Database\Eloquent\Factories\Factory;

class StylePanelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StylePanel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'style_id' => 1,
            'default_fabric_id' => 1,
        ];
    }
}

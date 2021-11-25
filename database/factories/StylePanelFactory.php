<?php

namespace Database\Factories;

use App\Models\Materials;
use App\Models\Style;
use App\Models\StylePanel;
use App\Models\StylePanelFabric;
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
            'style_id' => Style::factory()->create(),
            'default_fabric_id' => Materials::factory()->create(),
        ];
    }
}

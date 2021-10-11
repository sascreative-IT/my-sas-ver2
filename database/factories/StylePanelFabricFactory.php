<?php

namespace Database\Factories;

use App\Models\StylePanelFabric;
use Illuminate\Database\Eloquent\Factories\Factory;

class StylePanelFabricFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StylePanelFabric::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'style_panel_id' => 1,
            'material_id' => 1,
        ];
    }
}

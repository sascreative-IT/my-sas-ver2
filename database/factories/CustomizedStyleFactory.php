<?php

namespace Database\Factories;

use App\Models\CustomizedStyle;
use App\Models\ItemType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomizedStyle>
 */
class CustomizedStyleFactory extends Factory
{
    protected $model = CustomizedStyle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        $randomId = random_int(10000, 100000);

        return [
            'code' => 'code-' . $randomId ,
            'name' => 'name ' . $randomId,
            'production_time' => 5,
            'item_type_id' => ItemType::factory(),
            'description' => $this->faker->paragraph,
            'status' => 'active'
        ];
    }

    public function belongsToInternal()
    {
        return $this->state(function (array $attributes){
            return [
                'belongs_to' => 'internal'
            ];
        });
    }

    public function belongsToExternal()
    {
        return $this->state(function (array $attributes){
            return [
                'belongs_to' => 'external'
            ];
        });
    }
}

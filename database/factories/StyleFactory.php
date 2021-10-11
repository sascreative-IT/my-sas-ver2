<?php

namespace Database\Factories;

use App\Models\ItemType;
use App\Models\Style;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class StyleFactory extends Factory
{
    protected $model = Style::class;

    public function definition()
    {
        $randomId = random_int(10000, 100000);

        return [
            'code' => 'code-' . $randomId ,
            'name' => 'name ' . $randomId,
            'type_id' => ItemType::factory(),
            'description' => $this->faker->paragraph,
            'belongs_to' => Arr::random(['internal', 'external']),
            'status' => 'active',
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\ItemType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemTypeFactory extends Factory
{
    protected $model = ItemType::class;

    public function definition()
    {
        return [
            'name' => 'type ' . random_int(1000, 10000)
        ];
    }
}

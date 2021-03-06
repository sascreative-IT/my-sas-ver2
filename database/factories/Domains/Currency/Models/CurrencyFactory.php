<?php

namespace Database\Factories\Domains\Currency\Models;

use App\Domains\Currency\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->currencyCode(),
            'status' => $this->faker->randomElement(['Enabled','Disabled'])
        ];
    }
}

<?php

namespace Database\Factories\Domains\Currency\Models;

use App\Domains\Currency\Models\CurrencyExchangeRate;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyExchangeRateFactory extends Factory
{
    protected $model = CurrencyExchangeRate::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->currencyCode(),
            'rate' => $this->faker->randomNumber(2),
            'rate_on' => $this->faker->date
        ];
    }
}

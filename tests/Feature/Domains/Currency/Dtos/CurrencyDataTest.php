<?php

namespace Tests\Feature\Domains\Currency\Dtos;

use App\Domains\Currency\Dtos\CurrencyExchangeRateData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyDataTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_currency_data_is_valid()
    {
        $dto = new CurrencyExchangeRateData(
            name: $this->faker->currencyCode(),
            currencyRate: $this->faker->numberBetween(1, 200),
            currencyRateOn: $this->faker->date
        );
        $this->assertInstanceOf(CurrencyExchangeRateData::class, $dto);
    }
}

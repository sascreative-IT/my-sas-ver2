<?php

namespace Tests\Feature\Domains\Currency\Dtos;

use App\Domains\Currency\Dtos\CurrencyData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyDataTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_currency_data_is_valid()
    {
        $dto = new CurrencyData(
            name: $this->faker->currencyCode(),
            rate: $this->faker->numberBetween(1,200)
        );
        $this->assertInstanceOf(CurrencyData::class, $dto);
    }
}

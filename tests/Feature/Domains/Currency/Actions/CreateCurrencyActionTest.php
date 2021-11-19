<?php

namespace Tests\Feature\Domains\Currency\Actions;

use App\Domains\Currency\Actions\CreateCurrencyAction;
use App\Domains\Currency\Dtos\CurrencyData;
use App\Domains\Currency\Models\CurrencyExchangeRate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCurrencyActionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_a_currency_can_be_created()
    {
        $dto = new CurrencyData(
            name: 'LRK',
            rate: 123.50,
            currencyRateOn: $this->faker->date
        );

        $currency = (new CreateCurrencyAction())->execute($dto);

        $this->assertInstanceOf(CurrencyExchangeRate::class, $currency);
        $this->assertDatabaseCount(CurrencyExchangeRate::class, 1);
        $this->assertDatabaseHas(CurrencyExchangeRate::class, [
            'name' => 'LRK',
            'rate' => 123.50,
        ]);

    }
}

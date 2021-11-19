<?php

namespace Tests\Feature\Domains\Currency\Actions;

use App\Domains\Currency\Actions\CreateCurrencyAction;
use App\Domains\Currency\Actions\UpdateCurrencyAction;
use App\Domains\Currency\Dtos\CurrencyData;
use App\Domains\Currency\Models\CurrencyExchangeRate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCurrencyActionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_a_currency_can_be_updated()
    {
        $currency = CurrencyExchangeRate::factory()->create();

        $dto = new CurrencyData(
            name: 'LRK',
            rate: 123.50,
            currencyRateOn: $this->faker->date
        );

        $updated_currency = (new UpdateCurrencyAction())->execute($dto, $currency);

        $this->assertInstanceOf(CurrencyExchangeRate::class, $updated_currency);
        $this->assertDatabaseCount(CurrencyExchangeRate::class, 1);
        $this->assertDatabaseHas(CurrencyExchangeRate::class, [
            'name' => 'LRK',
            'rate' => 123.50,
        ]);
    }
}

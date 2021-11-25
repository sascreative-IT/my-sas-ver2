<?php

namespace Tests\Feature\Domains\Currency\Actions;

use App\Domains\Currency\Actions\CreateCurrencyExchangeRateAction;
use App\Domains\Currency\Actions\UpdateCurrencyExchangeRateAction;
use App\Domains\Currency\Dtos\CurrencyExchangeRateData;
use App\Domains\Currency\Models\CurrencyExchangeRate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCurrencyExchangeRateActionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_a_currency_can_be_updated()
    {
        $currency = CurrencyExchangeRate::factory()->create();

        $dto = new CurrencyExchangeRateData(
            name: 'LRK',
            currencyRate: 123.50,
            currencyRateOn: $this->faker->date
        );

        $updated_currency = (new UpdateCurrencyExchangeRateAction())->execute($dto, $currency);

        $this->assertInstanceOf(CurrencyExchangeRate::class, $updated_currency);
        $this->assertDatabaseCount(CurrencyExchangeRate::class, 1);
        $this->assertDatabaseHas(CurrencyExchangeRate::class, [
            'name' => 'LRK',
            'rate' => 123.50,
        ]);
    }
}

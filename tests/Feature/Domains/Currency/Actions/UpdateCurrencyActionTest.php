<?php

namespace Tests\Feature\Domains\Currency\Actions;

use App\Domains\Currency\Actions\CreateCurrencyAction;
use App\Domains\Currency\Actions\UpdateCurrencyAction;
use App\Domains\Currency\Dtos\CurrencyData;
use App\Domains\Currency\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCurrencyActionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_a_currency_can_be_updated()
    {
        $currency = Currency::factory()->create();

        $dto = new CurrencyData(
            name: 'LRK',
            rate: 123.50,
            currencyRateOn: $this->faker->date
        );

        $updated_currency = (new UpdateCurrencyAction())->execute($dto, $currency);

        $this->assertInstanceOf(Currency::class, $updated_currency);
        $this->assertDatabaseCount(Currency::class, 1);
        $this->assertDatabaseHas(Currency::class, [
            'name' => 'LRK',
            'rate' => 123.50,
        ]);
    }
}

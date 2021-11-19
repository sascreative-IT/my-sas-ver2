<?php

namespace Tests\Feature\Domains\Currency\Actions;

use App\Domains\Currency\Actions\CreateCurrencyAction;
use App\Domains\Currency\Actions\CreateCurrencyExchangeRateAction;
use App\Domains\Currency\Actions\UpdateCurrencyAction;
use App\Domains\Currency\Dtos\CurrencyData;
use App\Domains\Currency\Dtos\CurrencyExchangeRateData;
use App\Domains\Currency\Models\Currency;
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
        $currency = Currency::factory()->create();

        $dto = new CurrencyData(
            name: 'LRK',
            status: $this->faker->randomElement(['Enabled','Disabled'])
        );

        $currency = (new UpdateCurrencyAction())->execute($dto, $currency);

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertDatabaseCount(Currency::class, 1);
        $this->assertDatabaseHas(Currency::class, [
            'name' => 'LRK',
            'status' => $dto->status,
        ]);

    }
}

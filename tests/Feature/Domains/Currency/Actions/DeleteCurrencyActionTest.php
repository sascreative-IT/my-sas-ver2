<?php

namespace Tests\Feature\Domains\Currency\Actions;

use App\Domains\Currency\Actions\CreateCurrencyExchangeRateAction;
use App\Domains\Currency\Actions\DeleteCurrencyAction;
use App\Domains\Currency\Actions\DeleteCurrencyExchangeRateAction;
use App\Domains\Currency\Actions\UpdateCurrencyExchangeRateAction;
use App\Domains\Currency\Dtos\CurrencyExchangeRateData;
use App\Domains\Currency\Models\Currency;
use App\Domains\Currency\Models\CurrencyExchangeRate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCurrencyActionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_a_currency_can_be_deleted()
    {
        $currency = Currency::factory()->create();

        $currency_deleted = (new DeleteCurrencyAction())->execute($currency);

        $this->assertTrue($currency_deleted);
        $this->assertDatabaseCount(Currency::class, 0);
    }
}

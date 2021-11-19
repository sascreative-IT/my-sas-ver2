<?php

namespace Tests\Feature\Http\Controllers;

use App\Domains\Currency\Models\CurrencyExchangeRate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\TestHelpersTrait;

class SettingsCurrencyExchangeRateControllerTest extends TestCase
{
    use RefreshDatabase, TestHelpersTrait;

    public function test_it_renders_the_index_properly()
    {
        $user = User::factory()->create();
        CurrencyExchangeRate::factory()->count(10)->create();

        $this->actingAs($user);
        $this->get(route('settings.currency-exchange-rates.index'))
            ->assertSee(CurrencyExchangeRate::first()->name)
            ->assertStatus(200);
    }

    public function test_it_stores_properly()
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'LKR',
            'currencyRateOn' => '2021-12-12',
            'currencyRate' => '12.2134'
        ];
        $this->post(route('settings.currency-exchange-rates.store'),$data)
            ->assertStatus(302)
            ->assertRedirect(route('settings.currency-exchange-rates.index'));

        $this->assertDatabaseHas(CurrencyExchangeRate::class, [
            'name' => $data['name'],
            'rate' => $data['currencyRate'],
            'rate_on' => $data['currencyRateOn'],
        ]);
    }

    public function test_it_renders_edit_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $currency = CurrencyExchangeRate::factory()->create();

        $page = $this->get(route('settings.currency-exchange-rates.edit', [$currency]))
            ->assertStatus(200)
            ->viewData('page');

        $this->assertEquals('Settings/CurrencyExchangeRate/CurrencyExchangeRateUpdate', $page['component']);
        $this->assertArraysAreSimilar($currency->toArray(), $page['props']['currencyExchangeRate']);
    }

    public function test_it_updates_properly()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $currency = CurrencyExchangeRate::factory()->create();

        $data = [
            'name' => 'LKR',
            'currencyRateOn' => '2021-12-12',
            'currencyRate' => '12.2134'
        ];

        $this->put(route('settings.currency-exchange-rates.update', $currency->id),$data)
            ->assertStatus(302)
            ->assertRedirect(route('settings.currency-exchange-rates.index'));

        $this->assertDatabaseHas(CurrencyExchangeRate::class, [
            'name' => $data['name'],
            'rate' => $data['currencyRate'],
            'rate_on' => $data['currencyRateOn'],
        ]);
    }

    public function test_it_deletes_properly()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $currency = CurrencyExchangeRate::factory()->create();

        $this->deleteJson(route('settings.currency-exchange-rates.delete', $currency))
            ->assertStatus(302)
            ->assertRedirect(route('settings.currency-exchange-rates.index'));

        $this->assertDatabaseMissing(CurrencyExchangeRate::class, [
            'name' => $currency->name,
            'rate' => $currency->rate,
            'rate_on' => $currency->rate_on,
        ]);
    }
}

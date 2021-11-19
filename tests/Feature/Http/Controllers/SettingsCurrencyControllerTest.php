<?php

namespace Tests\Feature\Http\Controllers;

use App\Domains\Currency\Models\Currency;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\TestHelpersTrait;

class SettingsCurrencyControllerTest extends TestCase
{
    use RefreshDatabase, TestHelpersTrait;

    public function test_it_renders_the_index_properly()
    {
        $user = User::factory()->create();
        Currency::factory()->count(10)->create();

        $this->actingAs($user);
        $this->get(route('settings.currencies.index'))
            ->assertSee(Currency::first()->name)
            ->assertStatus(200);
    }

    public function test_it_stores_properly()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $this->actingAs($user);
        $data = [
            'name' => 'LKR',
            'currencyRateOn' => '2021-12-12',
            'currencyRate' => '12.2134'
        ];
        $this->post(route('settings.currencies.store'),$data)
            ->assertStatus(302)
            ->assertRedirect(route('settings.currencies.index'));

        $this->assertDatabaseHas(Currency::class, [
            'name' => $data['name'],
            'rate' => $data['currencyRate'],
            'rate_on' => $data['currencyRateOn'],
        ]);
    }
}

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

    public function test_it_renders_create_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);


        $page = $this->get(route('settings.currencies.create'))
            ->assertStatus(200)
            ->viewData('page');

        $this->assertEquals('Settings/Currency/CurrencyAdd', $page['component']);
    }


    public function test_it_stores_properly()
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'LKR',
            'status' => 'Enabled'
        ];

        $this->post(route('settings.currencies.store'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('settings.currencies.index'));

        $this->assertDatabaseHas(Currency::class, [
            'name' => $data['name'],
            'status' => $data['status']
        ]);
    }


    public function test_it_renders_edit_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $currency = Currency::factory()->create();

        $page = $this->get(route('settings.currencies.edit', [$currency]))
            ->assertStatus(200)
            ->viewData('page');

        $this->assertEquals('Settings/Currency/CurrencyUpdate', $page['component']);
        $this->assertArraysAreSimilar($currency->toArray(), $page['props']['currency']);
    }


    public function test_it_updates_properly()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $currency = Currency::factory()->create();

        $data = [
            'name' => 'LKR',
            'status' => 'Enabled'
        ];

        $this->put(route('settings.currencies.update', $currency->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('settings.currencies.index'));

        $this->assertDatabaseHas(Currency::class, [
            'name' => $data['name'],
            'status' => $data['status']
        ]);
    }

    public function test_it_deletes_properly()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $currency = Currency::factory()->create();

        $this->deleteJson(route('settings.currencies.delete', $currency))
            ->assertStatus(302)
            ->assertRedirect(route('settings.currencies.index'));

        $this->assertDatabaseMissing(Currency::class, [
            'name' => $currency->name,
            'status' => $currency->status
        ]);
    }
}

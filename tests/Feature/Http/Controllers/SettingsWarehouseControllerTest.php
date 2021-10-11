<?php
declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Constraint\Count;
use Tests\TestHelpersTrait;
use Tests\TestCase;

class SettingsWarehouseControllerTest extends TestCase
{
    use RefreshDatabase, TestHelpersTrait;
    public function test_route_works()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->get(route('settings.warehouses.index'))
            ->assertStatus(200);
    }

    public function test_it_renders_properly()
    {
        $user = User::factory()->create();

        Warehouse::factory()->create(['name' => 'Warehouse 1']);
        Warehouse::factory()->create(['name' => 'Warehouse 2']);

        $this->actingAs($user);
        $this->get(route('settings.warehouses.index'))
            ->assertSee('Settings\/Warehouse')
            ->assertSee('Warehouse 1')
            ->assertSee('Warehouse 2');
    }

    public function test_it_stores_properly()
    {
        $user = User::factory()->create();
        $country = Country::factory()->create(['name' => 'NZ', 'sort' => 'NZ']);

        $this->actingAs($user)
            ->post(route('settings.warehouses.index'), [
                'name' => 'W1',
                'country_id' => $country->id,
            ])
            ->assertStatus(302)
            ->assertRedirect(route('settings.warehouses.index'));

        $savedWarehouse = Warehouse::where(['name' => 'W1', 'country_id' => $country->id])->get();

        $this->assertCount(1, $savedWarehouse);
        $this->assertEquals('W1', $savedWarehouse->first()->name);
        $this->assertEquals($country->id, $savedWarehouse->first()->country_id);
    }

    public function test_renders_edit_page()
    {
        $user = User::factory()->create();

        $warehouse = Warehouse::factory()->create(['name' => 'W1']);

        $this->actingAs($user);
        $page = $this->get(route('settings.warehouses.edit', [$warehouse]))
            ->assertStatus(200)
            ->viewData('page');

        $this->assertEquals('Settings/Warehouses/WarehouseUpdate', $page['component']);
        $this->assertArraysAreSimilar($warehouse->toArray(), $page['props']['initWarehouse']);
        $this->assertEquals(Country::count(), count($page['props']['countries']));
    }

    public function test_it_successfully_updates()
    {
        $user = User::factory()->create();
        $warehouse = Warehouse::factory()->create(['name' => 'W1']);
        $newCountry = Country::factory()->create();
        $this->actingAs($user);
        $updateData = [
            'name' => 'Foo',
            'country_id' => $newCountry->id,
        ];

        $this->putJson(route('settings.warehouses.update', $warehouse), $updateData)
            ->assertStatus(302);

        $warehouse->refresh();
        $this->assertEquals('Foo', $warehouse->name);
        $this->assertEquals($newCountry->id, $warehouse->country_id);
    }

    public function test_it_deletes()
    {
        $user = User::factory()->create();
        $warehouse = Warehouse::factory()->create();

        $this->actingAs($user);
        $this->deleteJson(route('settings.warehouses.delete', $warehouse))
            ->assertStatus(302);

        $this->assertNull(
            Warehouse::find($warehouse->id)
        );
    }
}

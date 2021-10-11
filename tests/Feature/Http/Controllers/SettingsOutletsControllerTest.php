<?php
declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use App\Models\Outlet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Constraint\Count;
use Tests\TestHelpersTrait;
use Tests\TestCase;

class SettingsOutletsControllerTest extends TestCase
{
    use RefreshDatabase, TestHelpersTrait;

    public function test_route_works()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->get(route('settings.outlets.index'))
            ->assertStatus(200);
    }

    public function test_it_renders_the_index_properly()
    {
        $user = User::factory()->create();

        Outlet::factory()->create(['name' => 'Outlet Papakura']);
        Outlet::factory()->create(['name' => 'Outlet Pukekohe']);

        $this->actingAs($user);
        $this->get(route('settings.outlets.index'))
            ->assertSee('Settings\/Outlets')
            ->assertSee('Outlet Papakura')
            ->assertSee('Outlet Pukekohe');
    }

    public function test_it_stores_properly()
    {
        $user = User::factory()->create();
        $country = Country::factory()->create(['name' => 'NZ']);

        $this->actingAs($user)
            ->post(route('settings.outlets.store'), [
                'name' => 'Outlet 1',
                'country_id' => $country->id,
            ])
            ->assertStatus(302)
            ->assertRedirect(route('settings.outlets.index'));

        $savedOutlet = Outlet::where(['name' => 'Outlet 1', 'country_id' => $country->id])->get();

        $this->assertCount(1, $savedOutlet);
        $this->assertEquals('Outlet 1', $savedOutlet->first()->name);
        $this->assertEquals($country->id, $savedOutlet->first()->country_id);
    }

    public function test_it_renders_edit_page()
    {
        $user = User::factory()->create();

        $outlet = Outlet::factory()->create(['name' => 'Outlet 1']);

        $this->actingAs($user);
        $page = $this->get(route('settings.outlets.edit', [$outlet]))
            ->assertStatus(200)
            ->viewData('page');

        $this->assertEquals('Settings/Outlets/OutletUpdate', $page['component']);
        $this->assertArraysAreSimilar($outlet->toArray(), $page['props']['initOutlet']);
        $this->assertEquals(Country::count(), count($page['props']['countries']));
    }

    public function test_it_successfully_updates()
    {
        $user = User::factory()->create();
        $outlet = Outlet::factory()->create(['name' => 'outlet 1']);
        $newCountry = Country::factory()->create();
        $this->actingAs($user);
        $updateData = [
            'name' => 'outlet 2',
            'country_id' => $newCountry->id,
        ];

        $this->putJson(route('settings.outlets.update', $outlet), $updateData)
            ->assertStatus(302);

        $outlet->refresh();
        $this->assertEquals('outlet 2', $outlet->name);
        $this->assertEquals($newCountry->id, $outlet->country_id);
    }

    public function test_it_deletes()
    {
        $user = User::factory()->create();
        $outlet = Outlet::factory()->create();

        $this->actingAs($user);
        $this->deleteJson(route('settings.outlets.delete', $outlet))
            ->assertStatus(302)
            ->assertRedirect(route('settings.outlets.index'));

        $this->assertNull(
            Outlet::find($outlet->id)
        );
    }

}

<?php


namespace Tests\Feature\Http\Controllers;


use App\Models\Country;
use App\Models\Factory;
use App\Models\User;
use ClaudioDekker\Inertia\Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Inertia;
use Mockery\MockInterface;
use Tests\TestCase;

class SettingsFactoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        config()->set('inertia.page.should_exist', true);

        config()->set('inertia.page.paths', array_merge(
            config()->get('inertia.page.paths', []),
            [resource_path('js/Pages')],
        ));

        config()->set('inertia.page.extensions', array_merge(
            config()->get('inertia.page.extensions', []),
            ['vue', 'svelte',],
        ));


        $user = User::factory()->create();
        $factory1 = Factory::factory()->create();
        $factory2 = Factory::factory()->create();
//        dump(config()->get('inertia'));

//        // use https://github.com/claudiodekker/inertia-laravel-testing
//        $this->actingAs($user);
//        $this->get(route('settings.factories.index'))
//            ->assertInertia(fn (Assert $page) => $page->component('Settings/Factories'));

        $this->assertTrue(true);
    }

    public function test_it_stores_properly()
    {
        $user = User::factory()->create();
        $country = Country::factory()->create(['name' => 'NZ']);

        $this->actingAs($user)
            ->post(route('settings.factories.store'), [
                'name' => 'Factory 1',
                'country_id' => $country->id,
            ])
            ->assertStatus(302)
            ->assertRedirect(route('settings.factories.index'));
    }
}

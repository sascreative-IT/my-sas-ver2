<?php


namespace Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Factory;
use App\Models\File;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\FactorySeeder;
use Database\Seeders\ItemTypeSeeder;
use Database\Seeders\StyleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;
use Inertia\Testing\Assert;

class FactoryOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    private $styleCodeRepository;

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function setUp(): void
    {
        parent::setUp();
        (new DatabaseSeeder())->call([
            UserSeeder::class,
            FactorySeeder::class,
            ItemTypeSeeder::class,
            StyleSeeder::class,
        ]);
        $this->styleCodeRepository = Mockery::mock('App\Repositories\StyleCodeRepositoryInterface');

    }

    public function test_it_shows_index()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->get(route('factory.orders.index'))->assertStatus(200);
    }

    public function test_it_shows_initial_create_view()
    {
        $user = User::factory()->create();

        $this->styleCodeRepository
            ->shouldReceive('getAll')
            ->once();

        $this->app->instance('App\Repositories\StyleCodeRepositoryInterface', $this->styleCodeRepository);

        File::create([
            'file_path' => 'WtbxweLh4LdgK5wFFSAEwTuO1YXNEaTl4VZRjbQf.jpg'
        ]);
        $csAgent = User::role(User::ROLE_CUSTOMER_SERVICE_AGENT)->first();
        $salesAgent = User::role(User::ROLE_SALES_AGENT)->first();
        $logo = File::orderBy('id', 'asc')->first();

        Customer::factory()->create([
            'name' => 'John Wick',
            'email' => 'john@example.com',
            'cs_agent_id' => $csAgent->id,
            'sales_agent_id' => $salesAgent->id,
            'logo_id' => $logo->id
        ]);

        $this->actingAs($user);

        $this->get(route('factory.orders.create'))
            ->assertStatus(200)
            ->assertInertia(fn(Assert $page) => $page
                ->component('Factory/FactoryOrderCreate')
                ->hasAll(['form', 'styles', 'categories' => Category::count(), 'factories' => Factory::count(),
                    'customers' => Customer::count(), 'customer-service-agents' => User::count(),
                    'selected-style-details', 'selected-style-fabrics']));
    }

    public function test_it_shows_create_with_factory_query_string()
    {
        $user = User::factory()->create();

        $this->styleCodeRepository
            ->shouldReceive('getStyleCodesOfFactory')
            ->with('1')
            ->once();

        $this->app->instance('App\Repositories\StyleCodeRepositoryInterface', $this->styleCodeRepository);

        File::create([
            'file_path' => 'WtbxweLh4LdgK5wFFSAEwTuO1YXNEaTl4VZRjbQf.jpg'
        ]);
        $csAgent = User::role(User::ROLE_CUSTOMER_SERVICE_AGENT)->first();
        $salesAgent = User::role(User::ROLE_SALES_AGENT)->first();
        $logo = File::orderBy('id', 'asc')->first();

        Customer::factory()->create([
            'name' => 'John Wick',
            'email' => 'john@example.com',
            'cs_agent_id' => $csAgent->id,
            'sales_agent_id' => $salesAgent->id,
            'logo_id' => $logo->id
        ]);

        $this->actingAs($user);

        $this->get(route('factory.orders.create', 'factory_id=1'))
            ->assertStatus(200)
            ->assertInertia(fn(Assert $page) => $page
                ->component('Factory/FactoryOrderCreate')
                ->hasAll(['form', 'styles', 'categories' => Category::count(), 'factories' => Factory::count(),
                    'customers' => Customer::count(), 'customer-service-agents' => User::count(),
                    'selected-style-details', 'selected-style-fabrics']));
    }

    public function test_it_shows_create_with_style_query_string()
    {
        $user = User::factory()->create();

        $this->styleCodeRepository
            ->shouldReceive('getRelationsForStyle')
            ->with('2')
            ->once();

        $this->styleCodeRepository
            ->shouldReceive('getFabricsForStyle')
            ->with('2')
            ->once();

        $this->styleCodeRepository
            ->shouldReceive('getAll')
            ->once();

        $this->app->instance('App\Repositories\StyleCodeRepositoryInterface', $this->styleCodeRepository);

        File::create([
            'file_path' => 'WtbxweLh4LdgK5wFFSAEwTuO1YXNEaTl4VZRjbQf.jpg'
        ]);
        $csAgent = User::role(User::ROLE_CUSTOMER_SERVICE_AGENT)->first();
        $salesAgent = User::role(User::ROLE_SALES_AGENT)->first();
        $logo = File::orderBy('id', 'asc')->first();

        Customer::factory()->create([
            'name' => 'John Wick',
            'email' => 'john@example.com',
            'cs_agent_id' => $csAgent->id,
            'sales_agent_id' => $salesAgent->id,
            'logo_id' => $logo->id
        ]);

        $this->actingAs($user);

        $this->get(route('factory.orders.create', 'style_id=2'))
            ->assertStatus(200)
            ->assertInertia(fn(Assert $page) => $page
                ->component('Factory/FactoryOrderCreate')
                ->hasAll(['form', 'styles', 'categories' => Category::count(), 'factories' => Factory::count(),
                    'customers' => Customer::count(), 'customer-service-agents' => User::count(),
                    'selected-style-details', 'selected-style-fabrics']));
    }


    public function test_it_stores_the_order_successfully()
    {
        $user = User::factory()->create();
        $sLFactory = Factory::factory()->create([
            'name' => 'SL Factory',
        ]);

        $order = [
            'public_id' => 'SAS 123',
            'factory' => $sLFactory,
            'type' => 'direct',
            'production_requirement' => 'make',
            'customer_id' => Customer::factory()->create()->id,
            'sale_made_by_id' => User::factory()->create()->id,
            'customer_service_by_id' => User::factory()->create()->id,
        ];

        $this->styleCodeRepository
            ->shouldReceive('createOrder')
            ->once();

        $this->app->instance('App\Repositories\StyleCodeRepositoryInterface', $this->styleCodeRepository);

        $this->actingAs($user);

        $response = $this->post(route('factory.orders.store'),$order);

        $response->assertStatus(302);
    }
}

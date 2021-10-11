<?php
declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Address;
use App\Models\CustomerAddress;
use App\Models\CustomerContact;
use App\Models\File;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CustomersControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_route_works()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get(route('customers.index'))
            ->assertStatus(200);
    }

    public function test_it_renders_the_index_properly()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->get(route('customers.index'))
            ->assertStatus(200);
    }

    public function test_it_renders_the_create_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get(route('customers.create'))
            ->assertStatus(200);
    }
    public function test_it_stores_properly()
    {
        $user = User::factory()->create();
        $csAgent = User::factory()->create(['name' => 'Smith']);
        $salesAgent = User::factory()->create(['name' => 'Joe']);
        $file = UploadedFile::fake()->image('logo.jpg');
        Storage::fake('public');

        $this->actingAs($user);
        $request = [
            'logo' => $file
        ];
        $this->post(route('logo.create'), $request);
        $uploadedFile = File::query()->orderBy('id', 'desc')->first();

        $response = $this->post(route('customers.store'), [
                'name' => 'John Doe',
                'email' => 'testingemail@email.com',
                'description' => 'Lorem Ipsum.....',
                'cs_agent_id' => $csAgent->id,
                'sales_agent_id' => $salesAgent->id,
                'logo_id' => $uploadedFile->id
            ]);

        $savedCustomer = Customer::query()->orderBy('id', 'desc')->first();
        $response->assertStatus(302);
        $response->assertRedirect(route('customers.edit',[$savedCustomer->id]));
    }

    public function test_it_renders_edit_page()
    {
        $user = User::factory()->create();
        $uploadedFile = UploadedFile::fake()->image('logo.jpg');
        Storage::fake('public');

        $file = new File;
        $filePath = $uploadedFile->store('uploads', 'public');
        $file->file_path = pathinfo($filePath)['basename'];
        $file->save();

        $customer = Customer::factory()->create(['logo_id' => $file->id]);

        $this->actingAs($user);
        $page = $this->get(route('customers.edit', [$customer]))
            ->assertStatus(200)
            ->viewData('page');

        $this->assertEquals($customer->name, $page['props']['initCustomer']['name']);
    }

    public function test_it_deletes()
    {
        $user = User::factory()->create();

        $address = Address::factory()->create();
        $csAgent = User::factory()->create(['name' => 'Smith']);
        $salesAgent = User::factory()->create(['name' => 'Joe']);
        $uploadedFile = UploadedFile::fake()->image('logo.jpg');
        Storage::fake('public');

        $file = new File;
        $filePath = $uploadedFile->store('uploads', 'public');
        $file->file_path = pathinfo($filePath)['basename'];
        $file->save();

        $customer = Customer::factory()->create([
            'name' => 'John Doe',
            'email' => 'testingemail@email.com',
            'description' => 'Lorem Ipsum.....',
            'cs_agent_id' => $csAgent->id,
            'sales_agent_id' => $salesAgent->id,
            'logo_id' => $file->id
        ]);

        $customerAddress = CustomerAddress::query()->create([
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'type' => 'billing'
        ]);

        $customerContact = CustomerContact::factory()->create([
            'customer_id' => $customer->id
        ]);

        $this->actingAs($user);
        $response = $this->delete(route('customers.delete', $customer));

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.index'));
        $this->assertNull(Customer::find($customer->id));
        $this->assertNull(CustomerAddress::find($customerAddress->customer_id));
        $this->assertNull(CustomerContact::find($customerContact->customer_id));
    }

}

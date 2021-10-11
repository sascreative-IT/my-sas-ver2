<?php
declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerContact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerContactsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_properly()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $this->actingAs($user);
        $response = $this->post(route('customers.contacts.store'),[
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@gmail.com',
            'contact_no' => '0123456789',
            'designation' => 'his designation',
            'type' => 'Primary',
            'customer_id' => $customer->id
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.edit',[$customer->id]));
    }

    public function test_it_updates_properly()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $customerContact = CustomerContact::factory()->create([
            'type' => 'primary',
            'customer_id' => $customer->id
        ]);
        $updatedContact = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@gmail.com',
            'contact_no' => '0123456789',
            'designation' => 'his designation',
            'type' => 'Other',
            'customer_id' => $customer->id
        ];
        $this->actingAs($user);
        $response = $this->put(route('customers.contacts.update', $customerContact->id), $updatedContact);
        $customerContact->refresh();

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.edit',[$customer->id]));
        $this->assertEquals('Other', $customerContact->type);
    }

    public function test_it_deletes()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $customerContact = CustomerContact::factory()->create([
            'customer_id' => $customer->id
        ]);

        $this->actingAs($user);
        $response = $this->delete(route('customers.contacts.delete', $customerContact));

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.edit',[$customer->id]));
        $this->assertNull(CustomerContact::find($customerContact->id));
    }
}

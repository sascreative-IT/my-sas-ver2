<?php
declare(strict_types=1);


namespace Tests\Feature\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_properly()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $this->actingAs($user);
        $request = [
            'line_1' => 'Sri Jayawardhanapura',
            'line_2' => 'Colombo',
            'line_3' => 'Colombo',
            'city' => 'Kotte',
            'postal_code' => '111444',
            'country_id' => 1,
            'type' => 'primary',
            'customer_id' => $customer->id
        ];
        $response = $this->post(route('customers.addresses.store'),$request);
        $response->assertStatus(302);
        $response->assertRedirect(route('customers.edit',[$customer->id]));
    }

    public function test_it_updates_properly()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $address = Address::factory()->create();
        $customerAddress = CustomerAddress::query()->create([
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'type' => 'billing'
        ]);

        $this->actingAs($user);
        $request = [
            'line_1' => 'Sri Jayawardhanapura',
            'line_2' => 'Colombo',
            'line_3' => 'Colombo',
            'city' => 'Kotte',
            'postal_code' => '111444',
            'country_id' => 1,
            'type' => 'primary',
            'customer_id' => $customer->id
        ];
        $response = $this->put(route('customers.addresses.update', $address->id), $request);
        $customerAddress->refresh();

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.edit',[$customer->id]));
        $this->assertEquals($request['type'], $customerAddress->type);
        $this->assertEquals($request['customer_id'], $customerAddress->customer_id);
    }

    public function test_it_deletes()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $address = Address::factory()->create();
        $customerAddress = CustomerAddress::query()->create([
            'customer_id' => $customer->id,
            'address_id' => $address->id,
            'type' => 'billing'
        ]);

        $this->actingAs($user);
        $response = $this->delete(route('customers.addresses.delete', $address));

        $response->assertStatus(302);
        $response->assertRedirect(route('customers.edit',[$customer->id]));
        $this->assertNull(Address::find($address->id));
        $this->assertNull(CustomerAddress::find($customerAddress->address_id));
    }
}

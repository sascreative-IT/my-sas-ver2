<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'public_id' => 'SAS 123',
            'factory_id' => \App\Models\Factory::factory()->create()->id,
            'type' => 'direct',
            'production_requirement' => 'make',
            'customer_id' => Customer::factory()->create()->id,
            'sale_made_by_id' => User::factory()->create()->id,
            'customer_service_by_id' => User::factory()->create()->id,
        ];
    }
}

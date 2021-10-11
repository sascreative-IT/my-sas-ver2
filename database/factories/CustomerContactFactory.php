<?php

namespace Database\Factories;

use App\Models\CustomerContact;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerContact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'testJoe@gmail.com',
            'contact_no' => '098478394509',
            'designation' => 'designer',
            'type' => 'Other'
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{

    protected $model = Address::class;

    public function definition()
    {
        return [
            'line_1' => 'Sri Jayawardhanapura',
            'line_2' => 'Colombo',
            'line_3' => 'Colombo',
            'city' => 'Kotte',
            'postal_code' => '111444',
            'country_id' => 1
        ];
    }
}

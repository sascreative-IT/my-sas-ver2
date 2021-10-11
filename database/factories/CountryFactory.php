<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    protected $model = Country::class;

    public function definition()
    {
        $rand = rand(0, 100);
        return [
            'name' => 'Country ' . $rand,
            'sort' => 'C' .$rand,
        ];
    }
}

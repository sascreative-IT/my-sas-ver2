<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Factory as FactoryModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactoryFactory extends Factory
{
    protected $model = FactoryModel::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'country_id' => Country::find(1)->id,
        ];
    }
}

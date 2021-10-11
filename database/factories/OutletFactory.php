<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Outlet;
use Illuminate\Database\Eloquent\Factories\Factory;

class OutletFactory extends Factory
{

    /**
     * @var string
     */
    protected $model = Outlet::class;

    /* 
     * @return array
     */
    public function definition()
    {
        $rand = rand(0, 100);
        return [
            'name' => 'Outlet ' . $rand,
            'country_id' => Country::find(1)
        ];
    }
}

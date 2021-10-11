<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Factory;
use Illuminate\Database\Seeder;

class FactorySeeder extends Seeder
{
    public function run()
    {
        Factory::factory()->create([
            'name' => 'SL Factory',
            'country_id' => Country::where('sort', 'LK')->first()->id,
        ]);

        Factory::factory()->create([
            'name' => 'NZ Factory',
            'country_id' => Country::where('sort', 'NZ')->first()->id,
        ]);
    }
}


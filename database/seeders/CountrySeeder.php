<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $countries = [
            [
                'name' => 'Sri Lanka',
                'sort' => 'LK',
            ],
            [
                'name' => 'New Zealand',
                'sort' => 'NZ',
            ],
            [
                'name' => 'Thailand',
                'sort' => 'TH',
            ]
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}

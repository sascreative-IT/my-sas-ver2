<?php

namespace Tests\Unit\Models;

use App\Models\Country;
use App\Models\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCountry()
    {
        $country = Country::find(1);
        $factory = Factory::factory()->create([
            'name' => 'Test Factory',
            'country_id' => $country->id
        ]);

        $this->assertEquals($country->name, $factory->country->name);
    }
}

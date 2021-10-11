<?php
declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Country;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WarehouseTest extends TestCase
{
    use RefreshDatabase;

    public function test_country()
    {
        $country = Country::find(1);
        $warehouse = Warehouse::factory()->create([
            'name' => 'Warehouse 1',
            'country_id' => $country->id
        ]);

        $this->assertEquals($country->name, $warehouse->country->name);
    }
}

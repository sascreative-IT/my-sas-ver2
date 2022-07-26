<?php

namespace Domains\Styles\Actions;

use App\Domains\Styles\Actions\GetStyleIndex;
use App\Models\Customer;
use App\Models\CustomizedStyle;
use App\Models\NewCustomizedStyle;
use App\Models\Style;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetStyleIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_internal_customized_styles()
    {
        $generalStyle = Style::factory()->belongsToInternal()->create();
        $customer = Customer::factory()->create();
        CustomizedStyle::factory()->belongsToInternal()->count(1)->create([
            'customer_id' => $customer->id,
            'parent_style_id' => $generalStyle->id
        ]);

        $customizedStyleFromDb = CustomizedStyle::query()->internal()->with('itemType')->get();

        $index = (new GetStyleIndex())->execute(new CustomizedStyle(), 'internal');

        $this->assertEquals($customizedStyleFromDb->toArray(),$index->toArray()['data']);
    }

    public function test_it_returns_internal_new_customized_styles()
    {
        $customer = Customer::factory()->create();
        NewCustomizedStyle::factory()->belongsToInternal()->count(1)->create([
            'customer_id' => $customer->id,
        ]);

        $newCustomizedStyleFromDb = NewCustomizedStyle::query()->internal()->with('itemType')->get();

        $index = (new GetStyleIndex())->execute(new NewCustomizedStyle(), 'internal');

        $this->assertEquals($newCustomizedStyleFromDb->toArray(),$index->toArray()['data']);
    }
}

<?php

namespace Http\Controllers;

use App\Models\Customer;
use App\Models\CustomizedStyle;
use App\Models\Style;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CustomizedStylesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_index()
    {
        $user = User::factory()->create();
        $generalStyle = Style::factory()->belongsToInternal()->create();
        $customer = Customer::factory()->create();

        CustomizedStyle::factory()->belongsToInternal()->count(1)->create([
            'customer_id' => $customer->id,
            'parent_style_id' => $generalStyle->id
        ]);

        $customizedStyleFromDb = CustomizedStyle::query()->internal()->with('itemType')->get();

        $this->actingAs($user);

        $this->get('/customized-styles')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Styles/CustomizedStyles/Index')
            ->where('internal-styles.data', $customizedStyleFromDb));

    }
}

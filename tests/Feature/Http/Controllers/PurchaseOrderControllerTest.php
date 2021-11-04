<?php

namespace Tests\Feature\Http\Controllers;

use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Models\User;
use Tests\TestCase;

class PurchaseOrderControllerTest extends TestCase
{
    public function test_it_shows_index()
    {
        MaterialPurchaseOrder::factory()->count(30)->create();

        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get(route('purchase.orders.index'))->assertStatus(200);
    }
}

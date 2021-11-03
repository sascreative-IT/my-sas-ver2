<?php

namespace Tests\Feature\Http\Controllers;

use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrderItem;
use App\Models\Factory;
use App\Models\MaterialVariation;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get(route('purchase.orders.index'))->assertStatus(200);
    }


    public function test_it_shows_create_purchase_order()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get(route('purchase.orders.create'))->assertStatus(200);
    }

    public function test_a_purchase_order_can_be_created_successfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $supplier = Supplier::factory()->create();
        $factory = Factory::factory()->create();


        $purchase_order_items = [
            [
                'material_variation_id' => MaterialVariation::factory()->create()->id,
                'quantity' => rand(1, 10),
                'unit' => 'm',
                'price' => $this->faker->randomFloat(2, 10, 300),
                'currency' => 'NZD'
            ],
            [
                'material_variation_id' => MaterialVariation::factory()->create()->id,
                'quantity' => rand(1, 10),
                'unit' => 'm',
                'price' => $this->faker->randomFloat(2, 10, 300),
                'currency' => 'NZD'
            ]
        ];

        $purchase_order_data = [
            'supplier_id' => $supplier->id,
            'factory_id' => $factory->id,
            'approved_by' => $user->id,
            'approved_at' => now(),
            'items' => $purchase_order_items
        ];

        $this->post(
            route('purchase.orders.store'),
            $purchase_order_data
        )
            ->assertStatus(302);

        $this->assertDatabaseCount(MaterialPurchaseOrder::class, 1);
        $this->assertDatabaseCount(MaterialPurchaseOrderItem::class, 2);

        $this->assertDatabaseHas(MaterialPurchaseOrder::class, [
            'supplier_id' => $supplier->id,
            'factory_id' => $factory->id,
        ]);

        $purchase_order = MaterialPurchaseOrder::orderByDesc('id')->first();

        $this->assertDatabaseHas(
            MaterialPurchaseOrderItem::class,
            array_merge(
                $purchase_order_items[0],
                ['material_purchase_order_id' => $purchase_order->id]
            )
        );

        $this->assertDatabaseHas(
            MaterialPurchaseOrderItem::class,
            array_merge(
                $purchase_order_items[1],
                ['material_purchase_order_id' => $purchase_order->id]
            )
        );
    }
}

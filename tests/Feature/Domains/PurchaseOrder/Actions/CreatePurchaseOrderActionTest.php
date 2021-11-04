<?php


namespace Tests\Feature\Domains\PurchaseOrder\Actions;


use App\Domains\PurchaseOrder\Actions\CreatePurchaseOrderAction;
use App\Domains\PurchaseOrder\Dtos\PurchaseOrderData;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrderItem;
use App\Http\Requests\PurchaseOrder\StorePurchaseOrderRequest;
use App\Models\Factory;
use App\Models\MaterialVariation;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatePurchaseOrderActionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_create_purchase_order()
    {
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

        $dto = PurchaseOrderData::fromRequest(new StorePurchaseOrderRequest([
            'supplier_id' => $supplier->id,
            'factory_id' => $factory->id,
            'purchase_order_items' => $purchase_order_items,
        ]));

        $purchaseOrder = (new CreatePurchaseOrderAction())->execute($dto);
        $this->assertInstanceOf(MaterialPurchaseOrder::class, $purchaseOrder);
        $this->assertDatabaseCount(MaterialPurchaseOrder::class, 1);
        $this->assertDatabaseCount(MaterialPurchaseOrderItem::class, 2);
        $this->assertDatabaseHas('material_purchase_orders', [
            'supplier_id' => $supplier->id,
            'factory_id' => $factory->id,
            'evaluated_by' => null,
            'evaluated_at' => null,
        ]);

        $this->assertDatabaseHas('material_purchase_order_items', [
            'material_purchase_order_id' => $purchaseOrder->id,
            'material_variation_id' => $purchase_order_items[0]['material_variation_id'],
            'quantity' => $purchase_order_items[0]['quantity'],
            'unit' => $purchase_order_items[0]['unit'],
            'price' => $purchase_order_items[0]['price'],
            'currency' => $purchase_order_items[0]['currency'],
        ]);

        $this->assertDatabaseHas('material_purchase_order_items', [
            'material_purchase_order_id' => $purchaseOrder->id,
            'material_variation_id' => $purchase_order_items[1]['material_variation_id'],
            'quantity' => $purchase_order_items[1]['quantity'],
            'unit' => $purchase_order_items[1]['unit'],
            'price' => $purchase_order_items[1]['price'],
            'currency' => $purchase_order_items[1]['currency'],
        ]);

    }

}

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
        $user = User::factory()->create();
        $approved_at = now();
        $dto = PurchaseOrderData::fromRequest(new StorePurchaseOrderRequest([
            'supplier_id' => $supplier->id,
            'factory_id' => $factory->id,
            'approved_by' => $user->id,
            'approved_at' => $approved_at,
            'purchase_order_items' => [
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
            ]
        ]));

        $purchaseOrder = (new CreatePurchaseOrderAction())->execute($dto);
        $this->assertInstanceOf(MaterialPurchaseOrder::class, $purchaseOrder);
        $this->assertDatabaseCount(MaterialPurchaseOrder::class,1);
        $this->assertDatabaseCount(MaterialPurchaseOrderItem::class,2);
    }

}

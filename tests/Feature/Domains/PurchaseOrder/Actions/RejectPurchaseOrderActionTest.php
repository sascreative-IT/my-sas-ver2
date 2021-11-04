<?php


namespace Tests\Feature\Domains\PurchaseOrder\Actions;

use App\Domains\PurchaseOrder\Actions\RejectPurchaseOrderAction;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RejectPurchaseOrderActionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_a_purchase_order_can_be_rejected()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $material_purchase_order = MaterialPurchaseOrder::factory()
            ->withItems(3)
            ->create();


        $this->assertDatabaseHas('material_purchase_orders', [
            'id' => $material_purchase_order->id,
            'evaluation_status' => 'Pending',
            'evaluated_by' => null,
            'evaluated_at' => null,
        ]);

        (new RejectPurchaseOrderAction())->execute($material_purchase_order);

        $material_purchase_order = MaterialPurchaseOrder::find($material_purchase_order->id);

        $this->assertDatabaseHas('material_purchase_orders', [
            'id' => $material_purchase_order->id,
            'evaluation_status' => 'Rejected',
            'evaluated_by' => $user->id,
        ]);

        $this->assertNotNull($material_purchase_order->evaluated_at);
    }
}

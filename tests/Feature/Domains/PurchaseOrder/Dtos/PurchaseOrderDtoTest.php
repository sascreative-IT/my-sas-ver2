<?php

namespace Tests\Feature\Domains\PurchaseOrder\Dtos;

use App\Domains\PurchaseOrder\Dtos\PurchaseOrderData;
use App\Http\Requests\PurchaseOrder\StorePurchaseOrderRequest;
use App\Models\Factory;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseOrderDtoTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_purchase_order_request()
    {
        $supplier = Supplier::factory()->create();
        $factory = Factory::factory()->create();
        $user = User::factory()->create();

        $dto = PurchaseOrderData::fromRequest(new StorePurchaseOrderRequest([
            'supplier_id' => $supplier->id,
            'factory_id' => $factory->id,
            'approved_by' => $user->id,
            'approved_at' => now()
        ]));

        $this->assertInstanceOf(PurchaseOrderData::class, $dto);
    }

    public function test_store_purchase_order_request_without_approved_details()
    {
        $supplier = Supplier::factory()->create();
        $factory = Factory::factory()->create();

        $dto = PurchaseOrderData::fromRequest(new StorePurchaseOrderRequest([
            'supplier_id' => $supplier->id,
            'factory_id' => $factory->id
        ]));

        $this->assertInstanceOf(PurchaseOrderData::class, $dto);
    }

    public function test_store_purchase_order_request_without_supplier_fails()
    {
        $factory = Factory::factory()->create();
        $user = User::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        PurchaseOrderData::fromRequest(new StorePurchaseOrderRequest([
            'factory_id' => $factory->id,
            'approved_by' => $user->id,
            'approved_at' => now()
        ]));
    }

    public function test_store_purchase_order_request_with_null_supplier_fails()
    {
        $factory = Factory::factory()->create();
        $user = User::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        PurchaseOrderData::fromRequest(new StorePurchaseOrderRequest([
            'supplier_id' => null,
            'factory_id' => $factory->id,
            'approved_by' => $user->id,
            'approved_at' => now()
        ]));
    }
}

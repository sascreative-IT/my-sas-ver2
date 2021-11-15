<?php

namespace Tests\Feature\Domains\PurchaseOrder\Dtos;

use App\Domains\PurchaseOrder\Dtos\PurchaseOrderData;
use App\Http\Requests\PurchaseOrder\StorePurchaseOrderRequest;
use App\Models\Factory;
use App\Models\MaterialVariation;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PurchaseOrderDtoTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;


    public function test_store_purchase_order_request()
    {
        $supplier = Supplier::factory()->create();
        $factory = Factory::factory()->create();

        $dto = PurchaseOrderData::fromRequest(new StorePurchaseOrderRequest([
            'supplier_id' => $supplier->id,
            'factory_id' => $factory->id,
            'items' => [
                [
                    'material_variation_id' => MaterialVariation::factory()->create()->id,
                    'quantity' => rand(1, 10),
                    'unit' => 'm',
                    'unit_price' => $this->faker->randomFloat(2, 10, 300),
                    'sub_total' => $this->faker->randomFloat(2, 10, 300),
                    'currency' => 'NZD'
                ],
                [
                    'material_variation_id' => MaterialVariation::factory()->create()->id,
                    'quantity' => rand(1, 10),
                    'unit' => 'm',
                    'unit_price' => $this->faker->randomFloat(2, 10, 300),
                    'sub_total' => $this->faker->randomFloat(2, 10, 300),
                    'currency' => 'NZD'
                ]
            ]
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
            'purchase_order_items' => [
                [
                    'material_variation_id' => MaterialVariation::factory()->create()->id,
                    'quantity' => rand(1, 10),
                    'unit' => 'm',
                    'unit_price' => $this->faker->randomFloat(2, 10, 300),
                    'sub_total' => $this->faker->randomFloat(2, 10, 300),
                    'currency' => 'NZD'
                ],
                [
                    'material_variation_id' => MaterialVariation::factory()->create()->id,
                    'quantity' => rand(1, 10),
                    'unit' => 'm',
                    'unit_price' => $this->faker->randomFloat(2, 10, 300),
                    'sub_total' => $this->faker->randomFloat(2, 10, 300),
                    'currency' => 'NZD'
                ]
            ]
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
            'purchase_order_items' => [
                [
                    'material_variation_id' => MaterialVariation::factory()->create()->id,
                    'quantity' => rand(1, 10),
                    'unit' => 'm',
                    'unit_price' => $this->faker->randomFloat(2, 10, 300),
                    'sub_total' => $this->faker->randomFloat(2, 10, 300),
                    'currency' => 'NZD'
                ],
                [
                    'material_variation_id' => MaterialVariation::factory()->create()->id,
                    'quantity' => rand(1, 10),
                    'unit' => 'm',
                    'unit_price' => $this->faker->randomFloat(2, 10, 300),
                    'sub_total' => $this->faker->randomFloat(2, 10, 300),
                    'currency' => 'NZD'
                ]
            ]
        ]));
    }
}

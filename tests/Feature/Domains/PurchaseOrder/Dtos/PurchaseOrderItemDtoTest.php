<?php


namespace Tests\Feature\Domains\PurchaseOrder\Dtos;


use App\Domains\PurchaseOrder\Dtos\PurchaseOrderItemData;
use App\Http\Requests\PurchaseOrder\StorePurchaseOrderItemRequest;
use App\Models\MaterialVariation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PurchaseOrderItemDtoTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_store_purchase_order_item_request()
    {
        $materialVariation = MaterialVariation::factory()->create();

        $dto = PurchaseOrderItemData::fromRequest([
            'material_variation_id' => $materialVariation->id,
            'quantity' => rand(1, 10),
            'unit' => 'm',
            'price' => $this->faker->randomFloat(2, 10, 300),
            'currency' => 'NZD'
        ]);

        $this->assertInstanceOf(PurchaseOrderItemData::class, $dto);
    }

    public function test_store_purchase_order_item_request_without_material_variation_fails()
    {
        $this->expectException(\Exception::class);

        PurchaseOrderItemData::fromRequest([
            'quantity' => rand(1, 10),
            'unit' => 'm',
            'price' => $this->faker->randomFloat(2, 10, 300),
            'currency' => 'NZD'
        ]);
    }

    public function test_store_purchase_order_item_request_with_invalid_material_variation_fails()
    {
        $this->expectException(ModelNotFoundException::class);

        PurchaseOrderItemData::fromRequest([
            'material_variation_id' => 1000000000,
            'quantity' => rand(1, 10),
            'unit' => 'm',
            'price' => $this->faker->randomFloat(2, 10, 300),
            'currency' => 'NZD'
        ]);
    }
}

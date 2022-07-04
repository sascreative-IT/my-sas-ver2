<?php

namespace Tests\Feature\Domains\Inventories\AggregateRoots;

use App\Domains\Inventory\AggregateRoots\InventoryAggregateRoot;
use App\Domains\Inventory\Events\Internal\InventoryMaterialAdded;
use App\Domains\Inventory\Events\Internal\StockAdded;
use App\Domains\Inventory\Events\Internal\StockRemoved;
use App\Domains\Inventory\Exceptions\InventoryException;
use App\Models\Factory;
use App\Models\InventoryLog;
use App\Models\MaterialInventory;
use App\Models\MaterialVariation;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class InventoryAggregateRootTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_doesnt_create_new_material_for_inventory_when_exists()
    {
        $materialInventory = MaterialInventory::factory()->create();

        $this->expectException(InventoryException::class);
        $this->expectExceptionMessage('Material already exists');

        InventoryAggregateRoot::fake()
            ->when(function (InventoryAggregateRoot $aggregateRoot) use ($materialInventory) {
                $aggregateRoot->createMaterial(
                    $materialInventory->material_variation_id,
                    $materialInventory->supplier_id,
                    $materialInventory->factory_id,
                );
            })
            ->assertNotRecorded(InventoryMaterialAdded::class);
    }

    public function test_it_create_new_material_for_inventory()
    {
        $variation = MaterialVariation::factory()->create();
        $supplier = Supplier::factory()->create();
        $factory = Factory::factory()->create();

        InventoryAggregateRoot::fake()
            ->when(function (InventoryAggregateRoot $aggregateRoot) use ($variation, $supplier, $factory) {
                $aggregateRoot->createMaterial(
                    $variation->id,
                    $supplier->id,
                    $factory->id,
                );
            })
            ->assertRecorded(new InventoryMaterialAdded($variation->id, $supplier->id, $factory->id));
    }

    public function test_it_add_stock()
    {
        $variation = MaterialVariation::factory()->create();
        $supplier = Supplier::factory()->create();
        $factory = Factory::factory()->create();


        InventoryAggregateRoot::fake()
            ->when(function (InventoryAggregateRoot $aggregateRoot) use ($variation, $supplier, $factory) {
                $aggregateRoot->createMaterial(
                    $variation->id,
                    $supplier->id,
                    $factory->id,
                );
                $aggregateRoot->addStock('m', 100.99 );
            })
            ->assertRecorded([
                new InventoryMaterialAdded($variation->id, $supplier->id, $factory->id),
                new StockAdded('m', 100.99, 100.99)
            ]);
    }

    public function test_it_removes_stock()
    {
        InventoryAggregateRoot::fake()
            ->given([
                new StockAdded('m', 200, 200),
                new StockAdded('m', 50, 250),
                new StockAdded('m', 100.80, 350.80),
            ])
            ->when(function (InventoryAggregateRoot $aggregateRoot){
                $aggregateRoot->removeStock('m', 100.80);

                return $aggregateRoot;
            })
            ->then(function (InventoryAggregateRoot $aggregateRoot) {
                $this->assertEquals(250.0, $aggregateRoot->balance);
            })
            ->assertRecorded([
                new StockRemoved('m', 100.80)
            ]);
    }

    public function test_foo()
    {
        $variation = MaterialVariation::factory()->create();
        $supplier = Supplier::factory()->create();
        $factory = Factory::factory()->create();


        InventoryAggregateRoot::retrieve(Str::uuid()->toString())
            ->createMaterial(
                $variation->id,
                $supplier->id,
                $factory->id
            )
            ->addStock('m', 100.00)
            ->addStock('m', 50.00)
            ->persist()
        ;

        dd(InventoryLog::all()->toArray());
    }
}

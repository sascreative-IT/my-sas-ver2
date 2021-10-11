<?php
declare(strict_types=1);

namespace Tests\Feature\Repositories;

use App\Models\Colour;
use App\Models\Factory;
use App\Models\MaterialInventory;
use App\Models\MaterialInvoice;
use App\Models\MaterialInvoiceItem;
use App\Models\Materials;
use App\Models\MaterialSupplier;
use App\Models\MaterialVariation;
use App\Models\Supplier;
use App\Repositories\MaterialVariationRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaterialRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @todo have a look at this test, something doesnt feel right. */
    public function test_getAllFabricsWithSuppliers(): void
    {
        $factoryA = Factory::factory()->create();
        $factoryB = Factory::factory()->create();

        $coloursA = Colour::factory()->create();
        $coloursB = Colour::factory()->create();

        $materialA = Materials::factory()->create();
        $materialB = Materials::factory()->create();

        $materialAColorA = MaterialVariation::factory()->create([
            'material_id' => $materialA->id,
            'colour_id' => $coloursA->id
        ]);

        $materialAColorB = MaterialVariation::factory()->create([
            'material_id' => $materialA->id,
            'colour_id' => $coloursB->id
        ]);

        $supplierA = Supplier::factory()->create();

        MaterialSupplier::factory()->create([
            'variation_id' => $materialAColorA->id,
            'supplier_id' => $supplierA->id,
            'factory_id' => $factoryA->id
        ]);

        MaterialSupplier::factory()->create([
            'variation_id' => $materialAColorB->id,
            'supplier_id' => $supplierA->id,
            'factory_id' => $factoryA->id
        ]);

        MaterialSupplier::factory()->create([
            'variation_id' => $materialAColorA->id,
            'supplier_id' => $supplierA->id,
            'factory_id' => $factoryB->id
        ]);

        $this->assertCount(
            2,
            (new MaterialVariationRepository())->getAllFabricsWithSuppliers()
        );
    }
}

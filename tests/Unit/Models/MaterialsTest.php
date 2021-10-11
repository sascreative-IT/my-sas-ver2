<?php
declare(strict_types=1);

namespace Tests\Unit\Models;


use App\Models\Colour;
use App\Models\Factory;
use App\Models\Materials;
use App\Models\MaterialSupplier;
use App\Models\MaterialVariation;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\DataTransferObject\DataTransferObject;
use Tests\TestCase;

class MaterialsTest extends TestCase
{
    use RefreshDatabase;

    public function test_supplier_relationship(): void
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

        $this->assertCount(1, $materialAColorA->suppliers);
        $this->assertContains($supplierA->id, $materialAColorA->suppliers->pluck('id'));
    }
}

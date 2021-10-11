<?php


namespace Repositories;

use App\Models\Category;
use App\Models\Colour;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Factory;
use App\Models\ItemType;
use App\Models\MaterialInventory;
use App\Models\Materials;
use App\Models\MaterialVariation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemPanel;
use App\Models\Size;
use App\Models\StylePanel;
use App\Models\User;
use App\Repositories\StyleCodeRepository;
use Database\Factories\OrderFactory;
use Database\Factories\OrderItemFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\Feature\Traits\TestStylesSeeder;
use Tests\TestCase;

class StyleCodeRepositoryTest extends TestCase
{
    use RefreshDatabase;
    use TestStylesSeeder;

    protected $styleCodes;

    public function setUp(): void
    {
        parent::setUp();
        $this->styleCodes = new StyleCodeRepository;
    }

    public function test_it_gets_all_style_codes()
    {
        $sLFactory = Factory::factory()->create([
            'name' => 'SL Factory',
            'country_id' => Country::where('sort', 'LK')->first()->id,
        ]);

        $size1 = Size::firstOrCreate(['name' => 'S', 'slug' => 's']);
        $size2 = Size::firstOrCreate(['name' => 'M', 'slug' => 'm']);

        $category = Category::firstOrCreate([
            'name' => 'Basketball'
        ]);

        $itemType = ItemType::factory()->create([
            'name' => 'T-SHIRT/ POLO'
        ]);

        $customer = Customer::factory()->create();

        $style1 = $this->seedStyle($sLFactory, [$size1, $size2], $category, $itemType, $customer);

        $customer = Customer::factory()->create();
        $itemType = ItemType::firstOrCreate(['name' => 'SINGLET']);
        $category = Category::firstOrCreate([
            'name' => 'Basketball'
        ]);
        $size1 = Size::firstOrCreate(['name' => 'S', 'slug' => 's']);
        $size2 = Size::firstOrCreate(['name' => 'M', 'slug' => 'm']);

        $style2 = $this->seedStyle($sLFactory, [$size1, $size2], $category, $itemType, $customer);


        $this->assertCount(2, $this->styleCodes->getAll());
    }

    public function test_it_gets_styles_for_specific_factory()
    {
        $itemType = ItemType::factory()->create([
            'name' => 'T-SHIRT/ POLO'
        ]);
        $sLFactory = Factory::factory()->create([
            'name' => 'SL Factory',
        ]);
        $category = Category::firstOrCreate([
            'name' => 'Basketball'
        ]);
        $customer = Customer::factory()->create();
        $size1 = Size::firstOrCreate(['name' => 'S', 'slug' => 's']);
        $size2 = Size::firstOrCreate(['name' => 'M', 'slug' => 'm']);

        $style = $this->seedStyle($sLFactory, [$size1, $size2], $category, $itemType, $customer);

        $styleCodeForFactory = $this->styleCodes->getStyleCodesOfFactory($sLFactory->id);


        $this->assertCount(1, $styleCodeForFactory);
        $this->assertEquals($style->name, $styleCodeForFactory[0]->name);
    }

    public function test_it_gets_style_information_for_specific_style()
    {
        $itemType = ItemType::factory()->create([
            'name' => 'T-SHIRT/ POLO'
        ]);
        $sLFactory = Factory::factory()->create([
            'name' => 'SL Factory',
        ]);
        $category = Category::firstOrCreate([
            'name' => 'Basketball'
        ]);
        $customer = Customer::factory()->create();
        $size1 = Size::firstOrCreate(['name' => 'S', 'slug' => 's']);
        $size2 = Size::firstOrCreate(['name' => 'M', 'slug' => 'm']);

        $style = $this->seedStyle($sLFactory, [$size1, $size2], $category, $itemType, $customer);

        $deafultPanelFabric = Materials::factory()->create();
        $otherPanelFabric = Materials::factory()->create();

        $stylePanel = StylePanel::factory()->create([
            'style_id' => $style->id,
            'default_fabric_id' => $deafultPanelFabric->id,
        ]);

        $green = Colour::factory()->create([
            'name' => 'Green',
            'type' => 'fabric',
            'is_active' => 1,
        ]);

        $black = Colour::factory()->create([
            'name' => 'Black',
            'type' => 'fabric',
            'is_active' => 1,
        ]);

        $midDryTechGreen = MaterialVariation::factory()->create([
            'material_id' => $otherPanelFabric->id,
            'colour_id' => $green->id,
        ]);

        $midDryTechBlack = MaterialVariation::factory()->create([
            'material_id' => $otherPanelFabric->id,
            'colour_id' => $black->id,
        ]);

        $midDryTechGreenInventory = MaterialInventory::factory()->create([
            'material_variation_id' => $midDryTechGreen->id,
            'factory_id' => Factory::find(1) ? Factory::find(1)->id : Factory::factory()->create()->id,
        ]);

        $midDryTechBlackInventory = MaterialInventory::factory()->create([
            'material_variation_id' => $midDryTechBlack->id,
            'factory_id' => Factory::find(1) ? Factory::find(1)->id : Factory::factory()->create()->id,
        ]);

        $stylePanel = $this->seedStylePanelDetails($otherPanelFabric, $stylePanel);

        $styleDetails = $this->styleCodes->getRelationsForStyle($style->id);


        $this->assertEquals($style->id, $styleDetails->id);
        $this->assertEquals($style->name, $styleDetails->name);
        $this->assertEquals($stylePanel->name, $styleDetails["panels"][0]->name);
        $this->assertEquals($stylePanel["fabrics"][0]->id, $otherPanelFabric->id);
        $this->assertCount(2, $styleDetails["panels"][0]["fabrics"][0]["variations"]);
        $this->assertEquals(
            $styleDetails["panels"][0]["fabrics"][0]["variations"][0]->getAttributes(),
            $stylePanel["fabrics"][0]["variations"][0]->getAttributes()
        );
        $this->assertEquals(
            $styleDetails["panels"][0]["fabrics"][0]["variations"][0]->colour->getAttributes(),
            $stylePanel["fabrics"][0]["variations"][0]->colour->getAttributes()
        );
        $this->assertEquals(
            $styleDetails["panels"][0]["fabrics"][0]["variations"][0]->inventory->getAttributes(),
            $stylePanel["fabrics"][0]["variations"][0]->inventory->getAttributes()
        );
        $this->assertEquals(
            $styleDetails["panels"][0]->defaultFabric->getAttributes(),
            $stylePanel->defaultFabric->getAttributes()
        );

    }

    public function test_it_gets_style_fabric_information()
    {
        $itemType = ItemType::factory()->create([
            'name' => 'T-SHIRT/ POLO'
        ]);

        $sLFactory = Factory::factory()->create([
            'name' => 'SL Factory',
        ]);

        $category = Category::firstOrCreate([
            'name' => 'Basketball'
        ]);
        $customer = Customer::factory()->create();
        $size1 = Size::firstOrCreate(['name' => 'S', 'slug' => 's']);
        $size2 = Size::firstOrCreate(['name' => 'M', 'slug' => 'm']);

        $style = $this->seedStyle($sLFactory, [$size1, $size2], $category, $itemType, $customer);

        $deafultPanelFabric = Materials::factory()->create();
        $otherPanelFabric = Materials::factory()->create([
            "name" => "other panel fabric"
        ]);

        $stylePanel = StylePanel::factory()->create([
            'style_id' => $style->id,
            'default_fabric_id' => $deafultPanelFabric->id,
        ]);

        $green = Colour::factory()->create([
            'name' => 'Green',
            'type' => 'fabric',
            'is_active' => 1,
        ]);

        $black = Colour::factory()->create([
            'name' => 'Black',
            'type' => 'fabric',
            'is_active' => 1,
        ]);

        $midDryTechGreen = MaterialVariation::factory()->create([
            'material_id' => $otherPanelFabric->id,
            'colour_id' => $green->id,
        ]);

        $midDryTechBlack = MaterialVariation::factory()->create([
            'material_id' => $otherPanelFabric->id,
            'colour_id' => $black->id,
        ]);

        $midDryTechGreenInventory = MaterialInventory::factory()->create([
            'material_variation_id' => $midDryTechGreen->id,
            'factory_id' => Factory::find(1) ? Factory::find(1)->id : Factory::factory()->create()->id,
        ]);

        $midDryTechBlackInventory = MaterialInventory::factory()->create([
            'material_variation_id' => $midDryTechBlack->id,
            'factory_id' => Factory::find(1) ? Factory::find(1)->id : Factory::factory()->create()->id,
        ]);

        $stylePanel = $this->seedStylePanelDetails($otherPanelFabric, $stylePanel);

        $styleFabrics = $this->styleCodes->getFabricsForStyle($style->id);

        $this->assertEquals($styleFabrics[0]->getAttributes(), $otherPanelFabric->getAttributes());
    }

}

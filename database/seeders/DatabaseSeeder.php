<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Colour;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Factory;
use App\Models\File;
use App\Models\InventoryIn;
use App\Models\ItemType;
use App\Models\MaterialInventory;
use App\Models\MaterialInvoice;
use App\Models\MaterialInvoiceItem;
use App\Models\Materials;
use App\Models\MaterialVariation;
use App\Models\Size;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
//        User::factory()->create([
//            'email' => 'test@example.com',
//            'password' => 'test'
//        ])->assignRole(User::ROLE_CUSTOMER_SERVICE_AGENT);
//
//        User::factory()->create([
//            'email' => 'test2@example.com',
//            'password' => 'test2'
//        ])->assignRole(User::ROLE_SALES_AGENT);

//        $countries = [
//            [
//                'name' => 'Sri Lanka',
//                'sort' => 'LK',
//            ],
//            [
//                'name' => 'New Zealand',
//                'sort' => 'NZ',
//            ]
//        ];
//
//        foreach ($countries as $country) {
//            Country::create($country);
//        }

//        Factory::factory()->create([
//            'name' => 'SL Factory',
//            'country_id' => Country::where('sort', 'LK')->first()->id,
//        ]);
//
//        Factory::factory()->create([
//            'name' => 'NZ Factory',
//            'country_id' => Country::where('sort', 'NZ')->first()->id,
//        ]);
        $this->call([
            UserSeeder::class,
            CountrySeeder::class,
            FactorySeeder::class,
            WarehouseSeeder::class,
        ]);

        Warehouse::factory()->create([
            'name' => 'Warehouse 1',
            'country_id' => Country::where('sort', 'LK')->first()->id,
        ]);

        Warehouse::factory()->create([
            'name' => 'Warehouse 2',
            'country_id' => Country::where('sort', 'NZ')->first()->id,
        ]);

        $logos = [
            [
                'file_path' => 'WtbxweLh4LdgK5wFFSAEwTuO1YXNEaTl4VZRjbQf.jpg'
            ],
            [
                'file_path' => '2oRrAeFGKPFqRDMlON4BMue8DlK0CHlEkx11eMyr.png'
            ]
        ];

        foreach ($logos as $logo) {
            File::create($logo);
        }

        $logo1 = File::orderBy('id', 'asc')->first();
        $logo2 = File::orderBy('id', 'desc')->first();

        $csAgent = User::role(User::ROLE_CUSTOMER_SERVICE_AGENT)->first();
        $salesAgent = User::role(User::ROLE_SALES_AGENT)->first();

        Customer::factory()->create([
            'name' => 'John Doe',
            'cs_agent_id' => $csAgent->id,
            'sales_agent_id' => $salesAgent->id,
            'logo_id' => $logo1->id
        ]);

        Customer::factory()->create([
            'name' => 'Jane Doe',
            'cs_agent_id' => $csAgent->id,
            'sales_agent_id' => $salesAgent->id,
            'logo_id' => $logo2->id
        ]);

        $categories = collect([
            'Basketball',
            'Netball',
            'Rugby League',
            'Rugby',
            'Tag',
            'Touch',
            'Football',
            'Hockey',
        ]);

        $categories->map(function ($category) {
            Category::factory()->create([
                'name' => $category
            ]);
        });

        $types = collect([
            'T-SHIRT/ POLO',
            'LONG SLEEVE T-SHIRT/POLO',
            'HOODIE (CVC FLEECE)',
            'POLYESTER JACKET',
            'HOODIE SLEEVELESS (CVC FLEECE)',
            'TRACK JACKET',
            'TRACK PANT',
            'SINGLET',
            'POLYESTER CARGO SHORT',
        ]);


        $types->each(function ($type) {
            ItemType::factory()->create([
                'name' => $type
            ]);
        });

        $sizes = collect([
            '16K',
            '3XS',
            '2XS',
            'XS',
            'S',
            'M',
            'L',
            'XL',
            '2XL',
            '3XL'
        ]);

        $sizes->each(function ($size) {
            Size::factory()->create([
                'name' => $size,
                'slug' => Str::slug($size)
            ]);
        });

        $this->call([
            FileSeeder::class,
            CustomerSeeder::class,
            CategorySeeder::class,
            ItemTypeSeeder::class,
            SizeSeeder::class,
            StyleSeeder::class,
        ]);


        $midDryTech = Materials::factory()->create([
            'name' => 'Mid Dritech',
            'fiber_content' => '100% Polyester',
            'type' => 'fabric',
            'unit' => 'm'
        ]);

        $lightDritech = Materials::factory()->create([
            'name' => 'Light Dritech',
            'fiber_content' => '100% Polyester',
            'type' => 'fabric',
            'unit' => 'm'
        ]);

        $drytechRugby = Materials::factory()->create([
            'name' => 'Dritech Rugby',
            'fiber_content' => '100% Polyester',
            'type' => 'fabric',
            'unit' => 'm'
        ]);

        $white = Colour::factory()->create([
            'name' => 'White',
            'type' => 'fabric',
            'is_active' => 1,
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

        $red = Colour::factory()->create([
            'name' => 'Red',
            'type' => 'fabric',
            'is_active' => 1,
        ]);

        $blue = Colour::factory()->create([
            'name' => 'Blue',
            'type' => 'fabric',
            'is_active' => 1,
        ]);

        $midDryTechWhite = MaterialVariation::factory()->create([
            'material_id' => $midDryTech->id,
            'colour_id' => $white->id,
        ]);

        $midDryTechGreen = MaterialVariation::factory()->create([
            'material_id' => $midDryTech->id,
            'colour_id' => $green->id,
        ]);

        $midDryTechBlack = MaterialVariation::factory()->create([
            'material_id' => $midDryTech->id,
            'colour_id' => $black->id,
        ]);

        $midDryTechRed = MaterialVariation::factory()->create([
            'material_id' => $midDryTech->id,
            'colour_id' => $red->id,
        ]);

//        --
        $lightDritechWhite = MaterialVariation::factory()->create([
            'material_id' => $lightDritech->id,
            'colour_id' => $white->id,
        ]);

        $lightDritechGreen = MaterialVariation::factory()->create([
            'material_id' => $lightDritech->id,
            'colour_id' => $green->id,
        ]);

        $lightDritechBlack = MaterialVariation::factory()->create([
            'material_id' => $lightDritech->id,
            'colour_id' => $black->id,
        ]);

        $lightDritechRed = MaterialVariation::factory()->create([
            'material_id' => $lightDritech->id,
            'colour_id' => $red->id,
        ]);
//        --

        $supplierA = Supplier::factory()->create([
            'name' => 'Company A',
            'email' => 'email@example.com',
            'description' => '',
        ]);

        $supplierB = Supplier::factory()->create([
            'name' => 'Company B',
            'email' => 'emailb@example.com',
            'description' => '',
        ]);

        $invoice1 = MaterialInvoice::factory()->create([
            'supplier_id' => $supplierA->id,
            'purchase_order_number' => 'AB11234',
            'invoice_number' => 'ABC12211',
            'factory_id' => Factory::find(1) ? Factory::find(1)->id : Factory::factory()->create()->id,
        ]);

        MaterialInvoiceItem::factory()->create([
            'material_invoice_id' => $invoice1->id,
            'material_variation_id' => $lightDritechBlack->id,
            'quantity' => 100,
            'unit' => 'm',
            'price' => 800,
            'currency' => 'nzd'
        ]);

        MaterialInvoiceItem::factory()->create([
            'material_invoice_id' => $invoice1->id,
            'material_variation_id' => $lightDritechBlack->id,
            'quantity' => 500,
            'unit' => 'm',
            'price' => 1900,
            'currency' => 'nzd'
        ]);

        MaterialInvoiceItem::factory()->create([
            'material_invoice_id' => $invoice1->id,
            'material_variation_id' => $lightDritechGreen->id,
            'quantity' => 1000,
            'unit' => 'm',
            'price' => 1900,
            'currency' => 'nzd'
        ]);

        $lightDritechBlackInventory = MaterialInventory::factory()->create([
            'material_variation_id' => $lightDritechBlack->id,
            'unit' => 'm',
            'available_quantity' => 610,
            'allocated_quantity' => 100,
            'usable_quantity' => 500,
            'factory_id' => Factory::find(1) ? Factory::find(1)->id : Factory::factory()->create()->id,
        ]);

        $lightDritechGreenInventory = MaterialInventory::factory()->create([
            'material_variation_id' => $lightDritechGreen->id,
            'unit' => 'm',
            'available_quantity' => 1000,
            'allocated_quantity' => 0,
            'usable_quantity' => 1000,
            'factory_id' => Factory::find(1) ? Factory::find(1)->id : Factory::factory()->create()->id,
        ]);

        InventoryIn::create([
            'material_inventory_id' => $lightDritechBlackInventory->id,
            'invoice_id' => $invoice1->id,
            'quantity' => 600,
            'price' => 800
        ]);

        InventoryIn::create([
            'material_inventory_id' => $lightDritechBlackInventory->id,
            'description' => 'Monthly checking in',
            'quantity' => 10,
            'price' => 0
        ]);

    }
}

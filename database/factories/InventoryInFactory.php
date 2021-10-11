<?php

namespace Database\Factories;

use App\Domains\Invoices\Dtos\Invoice;
use App\Models\InventoryIn;
use App\Models\MaterialInventory;
use App\Models\MaterialInvoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryInFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InventoryIn::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
//            'material_inventory_id' => MaterialInventory::factory()->create(),
            'material_inventory_id' => MaterialInventory::find(1),
            'invoice_id' => MaterialInvoice::factory()->create() ,
            'quantity' => random_int(100, 1000),
            'price' => random_int(1000, 10000)
        ];
    }
}

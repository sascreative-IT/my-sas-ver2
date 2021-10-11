<?php

namespace Database\Factories;

use App\Models\MaterialInvoice;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialInvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MaterialInvoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'supplier_id' => Supplier::factory()->create(),
            'purchase_order_number' => (string) random_int(10000,10000),
            'invoice_number' => (string) random_int(10000,10000),
            'factory_id' => \App\Models\Factory::find(1),
        ];
    }
}

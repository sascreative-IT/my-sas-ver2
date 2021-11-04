<?php


namespace Database\Factories\Domains\Stock\Models;


use App\Domains\Stock\Models\StockOut;
use App\Domains\Stock\Models\StockOutItem;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockOutFactory extends Factory
{
    protected $model = StockOut::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'factory_id' => \App\Models\Factory::factory(),
            'customer_id' => \App\Models\Customer::factory(),
            'created_by_id' => \App\Models\User::factory(),
        ];
    }

    public function withItems(int $count = 1): StockOutFactory
    {
        return $this->afterCreating(function (StockOut $stockOut) use ($count) {
            StockOutItem::factory()->count($count)->create([
                'stock_out_id' => $stockOut->id,
            ]);
        });
    }
}

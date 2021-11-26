<?php


namespace Tests\Feature\Domains\Stock\Dtos;


use App\Domains\Stock\Dtos\StockOutData;
use App\Domains\Stock\Dtos\StockOutItemData;
use App\Http\Requests\StockOut\StockOutRequest;
use App\Models\Colour;
use App\Models\Customer;
use App\Models\Factory;
use App\Models\Materials;
use App\Models\Order;
use App\Models\Style;
use App\Models\StylePanel;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockOutDataTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private function generateItems(): array
    {
        return [
            [
                'style_id' => Style::factory()->create()->id,
                'style_panel_id' => StylePanel::factory()->create()->id,
                'material_id' => Materials::factory()->create()->id,
                'colour_id' => Colour::factory()->create()->id,
                'pieces' => rand(1, 10),
                'usage' => rand(1, 20)
            ],
            [
                'style_id' => Style::factory()->create()->id,
                'style_panel_id' => StylePanel::factory()->create()->id,
                'material_id' => Materials::factory()->create()->id,
                'colour_id' => Colour::factory()->create()->id,
                'pieces' => rand(1, 10),
                'usage' => rand(1, 20)
            ]
        ];
    }

    public function test_stock_out_data_is_valid()
    {
        $items = $this->generateItems();

        $stock_data = [
            'order_public_id' => Order::factory()->create()->public_id,
            'factory_id' => Factory::factory()->create()->id,
            'customer_id' => Customer::factory()->create()->id,
            'created_by_id' => User::factory()->create()->id,
            'items' => $items
        ];

        $dto = StockOutData::fromRequest(new StockOutRequest($stock_data));

        $this->assertInstanceOf(StockOutData::class, $dto);
    }


    public function test_stock_out_data_is_not_valid_when_order_id_is_empty()
    {
        $this->expectException(ModelNotFoundException::class);

        $items = $this->generateItems();

        $stock_data = [
            'factory_id' => Factory::factory()->create()->id,
            'customer_id' => Customer::factory()->create()->id,
            'created_by_id' => User::factory()->create()->id,
            'items' => $items
        ];

        StockOutData::fromRequest(new StockOutRequest($stock_data));
    }

}

<?php


namespace Tests\Feature\Domains\Stock\Actions;


use App\Domains\Stock\Actions\CreateStockOutAction;
use App\Domains\Stock\Dtos\StockOutData;
use App\Domains\Stock\Models\StockOut;
use App\Domains\Stock\Models\StockOutItem;
use App\Http\Requests\StockOut\StockOutRequest;
use App\Models\Colour;
use App\Models\Customer;
use App\Models\Factory;
use App\Models\Materials;
use App\Models\Order;
use App\Models\Style;
use App\Models\StylePanel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateStockOutActionTest extends TestCase
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

    public function test_a_stock_item_can_be_created()
    {
        $items = $this->generateItems();

        $order = Order::factory()->create();
        $stock_data = [
            'order_public_id' => $order->public_id,
            'factory_id' => Factory::factory()->create()->id,
            'customer_id' => Customer::factory()->create()->id,
            'created_by_id' => User::factory()->create()->id,
            'items' => $items
        ];

        $dto = StockOutData::fromRequest(new StockOutRequest($stock_data));

        $stockOut = (new CreateStockOutAction())->execute($dto);

        $this->assertInstanceOf(StockOut::class, $stockOut);
        $this->assertDatabaseCount(StockOut::class, 1);
        $this->assertDatabaseCount(StockOutItem::class, 2);


        $this->assertDatabaseHas('stock_outs', [
            'order_id' => $order->id,
            'factory_id' => $stock_data['factory_id'],
            'customer_id' => $stock_data['customer_id'],
            'created_by_id' => $stock_data['created_by_id'],
        ]);

        $this->assertDatabaseHas('stock_out_items', [
            'stock_out_id' => $stockOut->id,
            'style_id' => $items[0]['style_id'],
            'style_panel_id' => $items[0]['style_panel_id'],
            'material_id' => $items[0]['material_id'],
            'colour_id' => $items[0]['colour_id'],
            'pieces' => $items[0]['pieces'],
            'usage' => $items[0]['usage'],
        ]);
    }
}

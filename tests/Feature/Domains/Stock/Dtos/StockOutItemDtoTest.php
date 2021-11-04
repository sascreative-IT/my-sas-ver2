<?php


namespace Tests\Feature\Domains\Stock\Dtos;


use App\Domains\Stock\Dtos\StockOutItemData;
use App\Models\Colour;
use App\Models\Materials;
use App\Models\Style;
use App\Models\StylePanel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockOutItemDtoTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_stock_out_item_is_valid()
    {
        $stock_item_data = [
            'style_id' => Style::factory()->create()->id,
            'style_panel_id' => StylePanel::factory()->create()->id,
            'material_id' => Materials::factory()->create()->id,
            'colour_id' => Colour::factory()->create()->id,
            'pieces' => rand(1, 10),
            'usage' => rand(1, 20)
        ];

        $dto = StockOutItemData::fromRequest($stock_item_data);

        $this->assertInstanceOf(StockOutItemData::class, $dto);
    }

    public function test_stock_out_item_is_not_valid_when_style_is_empty()
    {
        $this->expectException(\TypeError::class);

        $stock_item_data = [
            'style_panel_id' => StylePanel::factory()->create()->id,
            'material_id' => Materials::factory()->create()->id,
            'colour_id' => Colour::factory()->create()->id,
            'pieces' => rand(1, 10),
            'usage' => rand(1, 20)
        ];

        StockOutItemData::fromRequest($stock_item_data);
    }

    public function test_stock_out_item_is_not_valid_when_style_is_invalid()
    {
        $this->expectException(ModelNotFoundException::class);

        $stock_item_data = [
            'style_id' => 10000,
            'style_panel_id' => StylePanel::factory()->create()->id,
            'material_id' => Materials::factory()->create()->id,
            'colour_id' => Colour::factory()->create()->id,
            'pieces' => rand(1, 10),
            'usage' => rand(1, 20)
        ];

        StockOutItemData::fromRequest($stock_item_data);
    }
}

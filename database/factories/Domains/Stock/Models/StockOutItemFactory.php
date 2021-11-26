<?php


namespace Database\Factories\Domains\Stock\Models;


use App\Domains\Stock\Models\StockOut;
use App\Domains\Stock\Models\StockOutItem;
use App\Models\Colour;
use App\Models\Materials;
use App\Models\Order;
use App\Models\Style;
use App\Models\StylePanel;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockOutItemFactory extends Factory
{
    protected $model = StockOutItem::class;

    public function definition(): array
    {
        return [
            'stock_out_id' => StockOut::factory(),
            'style_id' => Style::factory(),
            'style_panel_id' => StylePanel::factory(),
            'material_id' => Materials::factory(),
            'colour_id' => Colour::factory(),
            'pieces' => rand(1, 100),
            'usage' => rand(1, 100),
        ];
    }
}

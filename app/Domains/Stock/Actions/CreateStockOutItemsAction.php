<?php


namespace App\Domains\Stock\Actions;


use App\Domains\Stock\Models\StockOut;
use App\Domains\Stock\Models\StockOutItem;

class CreateStockOutItemsAction
{
    public function execute(array $stockOutItemsData, StockOut $stockOut): void
    {
        foreach ($stockOutItemsData as $stockOutItemData) {
            StockOutItem::create([
                'stock_out_id' => $stockOut->id,
                'style_id' => $stockOutItemData->style->id,
                'style_panel_id' => $stockOutItemData->stylePanel->id,
                'material_id' => $stockOutItemData->material->id,
                'colour_id' => $stockOutItemData->colour->id,
                'pieces' => $stockOutItemData->pieces,
                'usage' => $stockOutItemData->usage,
            ]);
        }
    }
}

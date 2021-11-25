<?php


namespace App\Domains\Stock\Actions;


use App\Domains\Stock\Dtos\StockOutData;
use App\Domains\Stock\Models\StockOut;

class CreateStockOutAction
{
    public function execute(StockOutData $stockOutData): StockOut
    {
        $materialPurchaseOrder = StockOut::create(
            [
                'order_id' => $stockOutData->order->id,
                'factory_id' => $stockOutData->factory->id,
                'customer_id' => $stockOutData->customer->id,
                'created_by_id' => $stockOutData->createdBy->id,
            ]
        );

        (new CreateStockOutItemsAction())
            ->execute($stockOutData->items, $materialPurchaseOrder);

        return $materialPurchaseOrder;
    }
}

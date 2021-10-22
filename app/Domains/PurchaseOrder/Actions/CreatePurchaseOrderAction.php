<?php


namespace App\Domains\PurchaseOrder\Actions;


use App\Domains\PurchaseOrder\Dtos\PurchaseOrderData;
use App\Domains\PurchaseOrder\Dtos\PurchaseOrderItemData;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;

class CreatePurchaseOrderAction
{
    public function execute(
        PurchaseOrderData $purchaseOrderData
    ): MaterialPurchaseOrder
    {
        $materialPurchaseOrder = MaterialPurchaseOrder::create(
            [
                'supplier_id' => $purchaseOrderData->supplier->id,
                'factory_id' => $purchaseOrderData->factory->id
            ]
        );

        (new CreatePurchaseOrderItemAction())->execute($purchaseOrderData->purchase_order_items, $materialPurchaseOrder);
        return $materialPurchaseOrder;
    }
}

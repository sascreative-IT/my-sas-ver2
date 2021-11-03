<?php


namespace App\Domains\PurchaseOrder\Actions;


use App\Domains\PurchaseOrder\Dtos\PurchaseOrderItemData;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrderItem;

class CreatePurchaseOrderItemsAction
{
    public function execute(array $purchaseOrderItemsData, MaterialPurchaseOrder $materialPurchaseOrder): void
    {
        foreach ($purchaseOrderItemsData as $purchaseOrderItemData) {
            MaterialPurchaseOrderItem::create([
                'material_purchase_order_id' => $materialPurchaseOrder->id,
                'material_variation_id' => $purchaseOrderItemData->material_variation->id,
                'quantity' => $purchaseOrderItemData->quantity,
                'unit' => $purchaseOrderItemData->unit,
                'price' => $purchaseOrderItemData->price,
                'currency' => $purchaseOrderItemData->currency
            ]);
        }
    }
}

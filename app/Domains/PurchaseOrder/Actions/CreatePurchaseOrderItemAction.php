<?php


namespace App\Domains\PurchaseOrder\Actions;


use App\Domains\PurchaseOrder\Dtos\PurchaseOrderItemData;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrderItem;

class CreatePurchaseOrderItemAction
{
    public function execute(array $purchaseOrderItemsData, MaterialPurchaseOrder $materialPurchaseOrder): bool
    {
        if (count($purchaseOrderItemsData) > 0) {
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
        return true;
    }
}

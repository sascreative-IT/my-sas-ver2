<?php


namespace App\Domains\PurchaseOrder\Actions;


use App\Domains\PurchaseOrder\Dtos\PurchaseOrderData;
use App\Domains\PurchaseOrder\Dtos\PurchaseOrderItemData;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Domains\PurchaseOrder\State\Approved;

class ApprovePurchaseOrderAction
{
    public function execute(MaterialPurchaseOrder $materialPurchaseOrder): MaterialPurchaseOrder
    {
        $materialPurchaseOrder->status->transitionTo(Approved::class);
        return $materialPurchaseOrder;
    }
}

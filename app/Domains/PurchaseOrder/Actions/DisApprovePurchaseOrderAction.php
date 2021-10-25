<?php


namespace App\Domains\PurchaseOrder\Actions;


use App\Domains\PurchaseOrder\Dtos\PurchaseOrderData;
use App\Domains\PurchaseOrder\Dtos\PurchaseOrderItemData;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Domains\PurchaseOrder\State\Approved;
use App\Domains\PurchaseOrder\State\Disapproved;

class DisApprovePurchaseOrderAction
{
    public function execute(MaterialPurchaseOrder $materialPurchaseOrder): MaterialPurchaseOrder
    {
        $materialPurchaseOrder->status->transitionTo(Disapproved::class);
        return $materialPurchaseOrder;
    }
}

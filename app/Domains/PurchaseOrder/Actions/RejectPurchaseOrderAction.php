<?php


namespace App\Domains\PurchaseOrder\Actions;


use App\Domains\PurchaseOrder\Dtos\PurchaseOrderData;
use App\Domains\PurchaseOrder\Dtos\PurchaseOrderItemData;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Domains\PurchaseOrder\State\Approved;
use App\Domains\PurchaseOrder\State\Disapproved;
use Illuminate\Support\Carbon;

class DisApprovePurchaseOrderAction
{
    public function execute(MaterialPurchaseOrder $materialPurchaseOrder): MaterialPurchaseOrder
    {
        $materialPurchaseOrder->update([
            'evaluation_status' => 'Rejected',
            'evaluated_by' => auth()->user()->id,
            'evaluated_at' => Carbon::now(),
        ]);
    }
}

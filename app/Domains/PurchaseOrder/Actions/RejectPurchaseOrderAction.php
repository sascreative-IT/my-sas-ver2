<?php


namespace App\Domains\PurchaseOrder\Actions;

use App\Domains\PurchaseOrder\Events\MaterialPurchaseOrderRejected;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use Illuminate\Support\Carbon;

class RejectPurchaseOrderAction
{
    public function execute(MaterialPurchaseOrder $materialPurchaseOrder): void
    {
        $materialPurchaseOrder->update([
            'evaluation_status' => MaterialPurchaseOrder::EVALUATION_STATUS_REJECTED,
            'evaluated_by' => auth()->user()->id,
            'evaluated_at' => Carbon::now(),
        ]);

        event(new MaterialPurchaseOrderRejected($materialPurchaseOrder));
    }
}

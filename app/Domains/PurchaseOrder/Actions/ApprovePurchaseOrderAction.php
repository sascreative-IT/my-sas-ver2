<?php


namespace App\Domains\PurchaseOrder\Actions;

use App\Domains\PurchaseOrder\Events\MaterialPurchaseOrderApproved;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Domains\PurchaseOrder\State\Approved;
use App\Jobs\NotifyUsersWhenMaterialPurchaseOrderApproved;
use Illuminate\Support\Carbon;

class ApprovePurchaseOrderAction
{
    public function execute(MaterialPurchaseOrder $materialPurchaseOrder): void
    {
        $materialPurchaseOrder->update([
            'evaluation_status' => MaterialPurchaseOrder::EVALUATION_STATUS_APPROVED,
            'evaluated_by' => auth()->user()->id,
            'evaluated_at' => Carbon::now(),
        ]);

        dispatch(new NotifyUsersWhenMaterialPurchaseOrderApproved($materialPurchaseOrder));
    }
}

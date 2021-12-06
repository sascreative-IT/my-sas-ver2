<?php

namespace App\Domains\PurchaseOrder\Listeners;

use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Jobs\NotifyUsersWhenMaterialPurchaseOrderApproved;

class MaterialPurchaseOrderApprovedListener
{
    public function __construct(MaterialPurchaseOrder $materialPurchaseOrder)
    {
        dispatch(new NotifyUsersWhenMaterialPurchaseOrderApproved($materialPurchaseOrder));
    }
}

<?php

namespace App\Domains\PurchaseOrder\Listeners;

use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Jobs\NotifyUsersWhenMaterialPurchaseOrderApproved;
use App\Jobs\NotifyUsersWhenMaterialPurchaseOrderRejected;

class MaterialPurchaseOrderRejectedListener
{
    public function __construct(MaterialPurchaseOrder $materialPurchaseOrder)
    {
        dispatch(new NotifyUsersWhenMaterialPurchaseOrderRejected($materialPurchaseOrder));
    }
}

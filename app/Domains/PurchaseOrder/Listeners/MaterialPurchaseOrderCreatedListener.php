<?php

namespace App\Domains\PurchaseOrder\Listeners;

use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Jobs\NotifyUsersWhenMaterialPurchaseOrderCreated;

class MaterialPurchaseOrderCreatedListener
{
    public function __construct(MaterialPurchaseOrder $materialPurchaseOrder)
    {
        dispatch(new NotifyUsersWhenMaterialPurchaseOrderCreated($materialPurchaseOrder));
    }
}

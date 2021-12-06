<?php

namespace App\Domains\PurchaseOrder\Subscribers;

use App\Domains\PurchaseOrder\Events\MaterialPurchaseOrderApproved;
use App\Domains\PurchaseOrder\Events\MaterialPurchaseOrderCreated;
use App\Domains\PurchaseOrder\Events\MaterialPurchaseOrderRejected;
use App\Domains\PurchaseOrder\Listeners\MaterialPurchaseOrderApprovedListener;
use App\Domains\PurchaseOrder\Listeners\MaterialPurchaseOrderCreatedListener;
use App\Domains\PurchaseOrder\Listeners\MaterialPurchaseOrderRejectedListener;
use App\Domains\PurchaseOrder\Listeners\NotifyUsersWhenMaterialPurchaseOrderCreated;

class MaterialPurchaseOrderSubscriber
{
    public function subscribe($events)
    {
        $events->listen(
            MaterialPurchaseOrderCreated::class,
            MaterialPurchaseOrderCreatedListener::class
        );

        $events->listen(
            MaterialPurchaseOrderApproved::class,
            MaterialPurchaseOrderApprovedListener::class
        );

        $events->listen(
            MaterialPurchaseOrderRejected::class,
            MaterialPurchaseOrderRejectedListener::class
        );
    }
}

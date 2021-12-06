<?php

namespace App\Domains\PurchaseOrder\Events;

use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MaterialPurchaseOrderCreated
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    private MaterialPurchaseOrder $materialPurchaseOrder;

    public function __construct(MaterialPurchaseOrder $materialPurchaseOrder)
    {
        $this->materialPurchaseOrder = $materialPurchaseOrder;
    }
}

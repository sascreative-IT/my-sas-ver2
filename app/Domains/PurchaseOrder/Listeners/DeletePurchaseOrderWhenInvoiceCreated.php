<?php

namespace App\Domains\PurchaseOrder\Listeners;

use App\Domains\Invoices\Events\InvoiceCreated;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;

class DeletePurchaseOrderWhenInvoiceCreated
{
    public function handle(InvoiceCreated $invoiceCreated)
    {
        $purchase_order_number = $invoiceCreated->invoice->purchase_order_number;
        $purchase_order = MaterialPurchaseOrder::find($purchase_order_number);
        $purchase_order?->delete();
    }
}

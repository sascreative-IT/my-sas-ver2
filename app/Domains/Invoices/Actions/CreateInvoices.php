<?php
declare(strict_types=1);

namespace App\Domains\Invoices\Actions;

use App\Domains\Invoices\Dtos\Invoice;
use App\Domains\Invoices\Dtos\InvoiceItem;
use App\Domains\Invoices\Events\InvoiceCreated;
use App\Models\MaterialInvoice;
use App\Models\MaterialInvoiceItem;
use App\Models\MaterialVariation;

class CreateInvoices
{
    public function execute(Invoice $invoice): void
    {
        $createdInvoice = MaterialInvoice::create([
            'supplier_id' => $invoice->supplier->id,
            'purchase_order_number' => $invoice->poNumber,
            'invoice_number' => $invoice->number,
            'factory_id' => $invoice->factory->id,
        ]);

        collect($invoice->items)
            ->map(function (InvoiceItem $item) use ($createdInvoice) {
                $variation = MaterialVariation::firstOrCreate([
                    'material_id' => $item->material->id,
                    'colour_id' => $item->colour->id,
                    // need to set the supplier
                ]);

                MaterialInvoiceItem::create([
                    'material_invoice_id' => $createdInvoice->id,
                    'material_variation_id' => $variation->id,
                    'quantity' => $item->quantity,
                    'unit' => $item->material->unit,
                    'price' => $item->price,
                    'currency' => 'nzd'
                ]);
        });

        InvoiceCreated::dispatch($createdInvoice);
    }
}

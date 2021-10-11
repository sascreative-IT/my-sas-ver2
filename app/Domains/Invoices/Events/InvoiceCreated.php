<?php
declare(strict_types=1);

namespace App\Domains\Invoices\Events;

use App\Models\MaterialInvoice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InvoiceCreated implements ShouldQueue
{
    use Dispatchable, SerializesModels, InteractsWithQueue;

    public MaterialInvoice $invoice;

    public function __construct(MaterialInvoice $invoice)
    {
        $this->invoice = $invoice;
    }
}

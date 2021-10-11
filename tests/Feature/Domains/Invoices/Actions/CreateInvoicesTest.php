<?php
declare(strict_types=1);

namespace Tests\Feature\Domains\Invoices\Actions;

use App\Domains\Invoices\Actions\CreateInvoices;
use App\Domains\Invoices\Dtos\Invoice;
use App\Domains\Invoices\Dtos\InvoiceItem;
use App\Models\Colour;
use App\Models\Factory;
use App\Models\MaterialInvoice;
use App\Models\Materials;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateInvoicesTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_executes()
    {
        $invoiceItem = new InvoiceItem();
        $invoiceItem->material = Materials::factory()->create();
        $invoiceItem->colour = Colour::factory()->create();
        $invoiceItem->price = 200;
        $invoiceItem->quantity = 100;

        $invoice = new Invoice();
        $invoice->factory = Factory::factory()->create();
        $invoice->supplier = Supplier::factory()->create();
        $invoice->number = '123';
        $invoice->poNumber = 'po-123';
        $invoice->invoicedDate = '2020-01-01';
        $invoice->items = [
            $invoiceItem
        ];

        (new CreateInvoices())->execute($invoice);

        $createdInvoice = MaterialInvoice::query()->where('invoice_number', $invoice->number)->first();

        $this->assertEquals($invoice->number, $createdInvoice->invoice_number);
    }
}

<?php
declare(strict_types=1);

namespace App\Domains\Inventory\Listeners;

use App\Domains\Inventory\Actions\CreateInventoryStockIn;
use App\Domains\Inventory\Actions\InventoryCreate;
use App\Domains\Invoices\Events\InvoiceCreated;
use App\Models\MaterialInvoiceItem;
use App\Models\Supplier;

class UpdateInventoryWhenInvoiceCreated
{
    private InventoryCreate $inventoryCreate;
    private CreateInventoryStockIn $createInventoryStockIn;

    public function __construct(InventoryCreate $inventoryCreate, CreateInventoryStockIn $createInventoryStockIn)
    {
        $this->createInventoryStockIn = $createInventoryStockIn;
        $this->inventoryCreate = $inventoryCreate;
    }

    public function handle(InvoiceCreated $invoiceCreated)
    {
        $invoiceCreated->invoice->items
            ->each(function (MaterialInvoiceItem $invoiceItem) use ($invoiceCreated) {
                $inventoryItem = $this->inventoryCreate->execute(
                    $invoiceItem->variation,
                    $invoiceCreated->invoice->sawingFactory,
                    $invoiceItem->variation->material->unit,
                    $invoiceCreated->invoice->supplier
                );

                $this->createInventoryStockIn->execute(
                    $inventoryItem,
                    $invoiceCreated->invoice,
                    $invoiceItem->quantity,
                    $invoiceItem->unit_price,
                    null
                );
            });
    }
}

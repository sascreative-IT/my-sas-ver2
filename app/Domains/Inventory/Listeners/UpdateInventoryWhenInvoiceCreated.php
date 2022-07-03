<?php
declare(strict_types=1);

namespace App\Domains\Inventory\Listeners;

use App\Domains\Inventory\Actions\CreateInventoryStockIn;
use App\Domains\Inventory\Actions\InventoryCreate;
use App\Domains\Inventory\AggregateRoots\InventoryAggregateRoot;
use App\Domains\Inventory\Repositories\InventoryRepository;
use App\Domains\Invoices\Events\InvoiceCreated;
use App\Models\MaterialInvoiceItem;
use App\Models\Supplier;
use Illuminate\Support\Str;

class UpdateInventoryWhenInvoiceCreated
{
    private InventoryRepository $inventoryRepository;

    public function __construct(InventoryRepository $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    public function handle(InvoiceCreated $invoiceCreated)
    {
        $invoiceCreated->invoice->loadMissing(['items']);
        $invoiceCreated->invoice->items->each(function (MaterialInvoiceItem $invoiceItem) use ($invoiceCreated) {
            $InventoryMaterial = $this->inventoryRepository->getMaterial(
                $invoiceItem->material_variation_id,
                $invoiceCreated->invoice->supplier_id,
                $invoiceCreated->invoice->factory_id,
            );

            $aggregateRoot = InventoryAggregateRoot::retrieve($InventoryMaterial ? $InventoryMaterial->aggregate_id : Str::uuid()->toString());

            if ($InventoryMaterial === null) {
                $aggregateRoot->createMaterial(
                    $invoiceItem->material_variation_id,
                    $invoiceCreated->invoice->supplier_id,
                    $invoiceCreated->invoice->factory_id,
                    auth()->user()->id
                );
            }

            $aggregateRoot->addStock(
                $invoiceItem->unit,
                $invoiceItem->quantity,
                $invoiceItem->id,
                $invoiceItem->unit_price,
                $invoiceItem->currency,
                auth()->user()->id
            );

            $aggregateRoot->persist();
        });
    }
}

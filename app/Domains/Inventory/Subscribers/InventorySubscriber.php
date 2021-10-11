<?php
declare(strict_types=1);

namespace App\Domains\Inventory\Subscribers;


use App\Domains\Inventory\Events\NewStockAddedToInventory;
use App\Domains\Inventory\Listeners\UpdateAggregationWhenInventoryUpdated;
use App\Domains\Inventory\Listeners\UpdateInventoryWhenInvoiceCreated;
use App\Domains\Invoices\Events\InvoiceCreated;

class InventorySubscriber
{
    public function subscribe($events)
    {
        $events->listen(
            InvoiceCreated::class,
            UpdateInventoryWhenInvoiceCreated::class
        );

        $events->listen(
            NewStockAddedToInventory::class,
            UpdateAggregationWhenInventoryUpdated::class,
        );
    }
}

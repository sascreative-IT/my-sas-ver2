<?php
declare(strict_types=1);

namespace App\Domains\Inventory\Actions;

use App\Domains\Inventory\AggregateRoots\InventoryAggregateRoot;
use App\Models\MaterialInventory;
use App\Models\MaterialInvoice;

class CreateInventoryStockIn
{
    public function execute(MaterialInventory $inventory, ?MaterialInvoice $invoice, float $quantity, $userId, $reason)
    {
        $aggregateRoot = InventoryAggregateRoot::retrieve($inventory->aggregate_id);

        if ($quantity > 0) {
            $aggregateRoot->addStockViaStockAdjust(
                $inventory->unit,
                $quantity,
                $userId,
                $reason
            );

            $aggregateRoot->persist();
        }

        if ($quantity < 0) {
            $quantity = abs($quantity);
            $aggregateRoot->removeStockViaStockAdjust(
                $inventory->unit,
                $quantity,
                $userId,
                $reason
            );

            $aggregateRoot->persist();
        }

    }
}

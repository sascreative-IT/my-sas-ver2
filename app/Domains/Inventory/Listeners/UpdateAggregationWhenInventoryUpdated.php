<?php
declare(strict_types=1);

namespace App\Domains\Inventory\Listeners;

use App\Domains\Inventory\Actions\CalculateAggregationForInventoryItem;
use App\Domains\Inventory\Events\NewStockAddedToInventory;
use App\Models\MaterialInventory;

class UpdateAggregationWhenInventoryUpdated
{
    private CalculateAggregationForInventoryItem $calculateAggregationForInventoryItem;

    public function __construct(CalculateAggregationForInventoryItem $calculateAggregationForInventoryItem)
    {
        $this->calculateAggregationForInventoryItem
            = $calculateAggregationForInventoryItem;
    }

    public function handle(NewStockAddedToInventory $newStockAddedToInventory)
    {
        $this->calculateAggregationForInventoryItem->execute($newStockAddedToInventory->inventory);
    }
}

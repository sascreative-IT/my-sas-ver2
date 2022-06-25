<?php

namespace App\Domains\Inventory\Events\Internal;

class InventoryMaterialAdded extends \Spatie\EventSourcing\StoredEvents\ShouldBeStored
{
    public int $variationId;
    public int $supplierId;
    public int $factoryId;

    public function __construct(int $variationId, int $supplierId, int $factoryId)
    {
        $this->variationId = $variationId;
        $this->supplierId = $supplierId;
        $this->factoryId = $factoryId;
    }
}

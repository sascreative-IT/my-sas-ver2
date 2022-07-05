<?php

namespace App\Domains\Inventory\Events\Internal;

class InventoryMaterialAdded extends \Spatie\EventSourcing\StoredEvents\ShouldBeStored
{
    public int $variationId;
    public int $userId;
    public int $supplierId;
    public int $factoryId;

    public function __construct(int $variationId, int $supplierId, int $factoryId, $userId)
    {
        $this->variationId = $variationId;
        $this->userId = $userId;
        $this->supplierId = $supplierId;
        $this->factoryId = $factoryId;
    }
}

<?php

namespace App\Domains\Inventory\Events\Internal;

class StockRemovedManually extends \Spatie\EventSourcing\StoredEvents\ShouldBeStored
{
    public string $unit;
    public float $quantity;
    public int $userId;
    public ?string $reason;

    public function __construct(string $unit, float $quantity, int $userId, ?string $reason = null)
    {
        $this->unit = $unit;
        $this->quantity = $quantity;
        $this->userId = $userId;
        $this->reason = $reason;
    }
}

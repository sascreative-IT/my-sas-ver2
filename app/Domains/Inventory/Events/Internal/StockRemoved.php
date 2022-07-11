<?php

namespace App\Domains\Inventory\Events\Internal;

class StockRemoved extends \Spatie\EventSourcing\StoredEvents\ShouldBeStored
{
    public string $unit;
    public float $quantity;
    public ?int $stylePanelId;
    public ?int $outOrderId;
    public int $userId;

    public function __construct(string $unit, float $quantity, ?int $stylePanelId = null, ?int $outOrderId = null, int $userId)
    {
        $this->unit = $unit;
        $this->quantity = $quantity;
        $this->stylePanelId = $stylePanelId;
        $this->outOrderId = $outOrderId;
        $this->userId = $userId;
    }
}

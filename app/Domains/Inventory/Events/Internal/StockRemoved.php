<?php

namespace App\Domains\Inventory\Events\Internal;

class StockRemoved extends \Spatie\EventSourcing\StoredEvents\ShouldBeStored
{
    public string $unit;
    public float $quantity;
    public int $stylePanelId;
    public int $outOrderId;

    public function __construct(string $unit, float $quantity, int $stylePanelId, int $outOrderId)
    {
        $this->unit = $unit;
        $this->quantity = $quantity;
        $this->stylePanelId = $stylePanelId;
        $this->outOrderId = $outOrderId;
    }
}

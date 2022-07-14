<?php

namespace App\Domains\Inventory\Events\Internal;

class StockAddedManually extends \Spatie\EventSourcing\StoredEvents\ShouldBeStored
{
    public string $unit;
    public float $quantity;
    public ?float $unitPrice;
    public ?string $currency;
    public ?string $reason;
    public int $userId;

    public function __construct(string $unit, float $quantity, ?float $unitPrice = null, ?string $currency = null, int $userId, ?string $reason = null)
    {
        $this->unit = $unit;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->currency = $currency;
        $this->userId = $userId;
        $this->reason = $reason;
    }
}

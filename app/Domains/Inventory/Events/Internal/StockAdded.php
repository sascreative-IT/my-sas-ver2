<?php

namespace App\Domains\Inventory\Events\Internal;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class StockAdded extends ShouldBeStored
{
    public string $unit;
    public float $quantity;
    public ?int $invoiceItemId;
    public ?float $unitPrice;
    public ?string $currency;
    public int $userId;

    public function __construct(string $unit, float $quantity, ?int $invoiceItemId = null, ?float $unitPrice = null, ?string $currency = null, int $userId)
    {
        $this->unit = $unit;
        $this->quantity = $quantity;
        $this->invoiceItemId = $invoiceItemId;
        $this->unitPrice = $unitPrice;
        $this->currency = $currency;
        $this->userId = $userId;
    }
}

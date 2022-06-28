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

    public function __construct(string $unit, float $quantity, ?int $invoiceItemId = null, ?float $unitPrice = null, ?string $currency = null)
    {
        $this->unit = $unit;
        $this->quantity = $quantity;
        $this->invoiceItemId = $invoiceItemId;
        $this->unitPrice = $unitPrice;
        $this->currency = $currency;
    }
}

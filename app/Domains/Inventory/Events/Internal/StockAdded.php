<?php

namespace App\Domains\Inventory\Events\Internal;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class StockAdded extends ShouldBeStored
{
    public string $unit;
    public float $quantity;
    public float $newBalance;
    public ?int $invoiceItemId;
    public ?float $unitPrice;
    public ?string $currency;

    public function __construct(string $unit, float $quantity, float $newBalance, ?int $invoiceItemId = null, ?float $unitPrice = null, ?string $currency = null)
    {
        $this->unit = $unit;
        $this->quantity = $quantity;
        $this->newBalance = $newBalance;
        $this->invoiceItemId = $invoiceItemId;
        $this->unitPrice = $unitPrice;
        $this->currency = $currency;
    }
}

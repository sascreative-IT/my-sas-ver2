<?php

namespace App\Domains\Inventory\AggregateRoots;

use App\Domains\Inventory\Events\Internal\InventoryMaterialAdded;
use App\Domains\Inventory\Events\Internal\StockAdded;
use App\Domains\Inventory\Events\Internal\StockRemoved;
use App\Domains\Inventory\Exceptions\InventoryException;
use App\Domains\Inventory\Repositories\InventoryRepository;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class InventoryAggregateRoot extends AggregateRoot
{
    private InventoryRepository $inventoryRepository;
    public float $balance = 0;

    public function __construct(InventoryRepository $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    public function createMaterial(int $variationId, int $supplierId, int $factoryId)
    {
        if ($this->inventoryRepository->isMaterialExist($variationId, $supplierId, $factoryId)) {
            throw InventoryException::materialExists();
        }

        $this->recordThat(new InventoryMaterialAdded($variationId, $supplierId, $factoryId));
    }

    public function addStock(string $unit, float $quantity, ?int $invoiceItemId = null, ?float $unitPrice = null, ?string $currency = null)
    {
        $this->recordThat(new StockAdded($unit, $quantity, $invoiceItemId, $unitPrice, $currency));
    }

    public function applyStockAdded(StockAdded $stockAdded)
    {
        $this->balance += $stockAdded->quantity;
    }

    public function removeStock(string $unit, float $quantity)
    {
        $this->recordThat(new StockRemoved($unit, $quantity));
    }

    public function applyStockRemoved(StockRemoved $stockAdded)
    {
        $this->balance -= $stockAdded->quantity;
    }
}

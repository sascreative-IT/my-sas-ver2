<?php
declare(strict_types=1);

namespace App\Domains\Inventory\Actions;

use App\Models\MaterialInventory;

/**
 * @deprecated
 * Class IncreaseAvailableQuantity
 *
 * @package App\Domains\Inventory\Actions
 */
class IncreaseAvailableQuantity
{
    public function execute(MaterialInventory $inventory, float $increaseAmount)
    {
        $inventory->available_quantity = $inventory->available_quantity + $increaseAmount;
        $inventory->usable_quantity = $inventory->available_quantity - $inventory->allocated_quantity;
        $inventory->save();
    }
}

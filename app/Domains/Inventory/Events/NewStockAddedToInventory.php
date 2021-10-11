<?php
declare(strict_types=1);

namespace App\Domains\Inventory\Events;

use App\Models\MaterialInventory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewStockAddedToInventory implements ShouldQueue
{
    use Dispatchable, SerializesModels, InteractsWithQueue;

    public MaterialInventory $inventory;

    public function __construct(MaterialInventory $inventory)
    {
        $this->inventory = $inventory;
    }
}

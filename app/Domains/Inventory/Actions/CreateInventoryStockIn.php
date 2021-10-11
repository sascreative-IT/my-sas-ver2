<?php
declare(strict_types=1);

namespace App\Domains\Inventory\Actions;

use App\Domains\Inventory\Events\NewStockAddedToInventory;
use App\Models\InventoryIn;
use App\Models\MaterialInventory;
use App\Models\MaterialInvoice;

class CreateInventoryStockIn
{
    public function execute(MaterialInventory $inventory, ?MaterialInvoice $invoice, float $quantity, float $price, ?string $description)
    {
        InventoryIn::create([
            'material_inventory_id' => $inventory->id,
            'invoice_id' => optional($invoice)->id,
            'quantity' => $quantity,
            'price' => $price,
            'description' => $description
        ]);

        event(new NewStockAddedToInventory($inventory));
    }
}

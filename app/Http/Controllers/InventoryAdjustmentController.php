<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\Inventory\Actions\CreateInventoryStockIn;
use App\Domains\Inventory\Actions\IncreaseAvailableQuantity;
use App\Models\InventoryIn;
use App\Models\MaterialInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class InventoryAdjustmentController
{
    public function store(CreateInventoryStockIn $createInventoryStockIn, MaterialInventory $inventory, Request $request)
    {
//        InventoryIn::create([
//            'material_inventory_id' => $inventory->id,
//            'quantity' => (float) $request->input('quantity'),
//            'price' => 0,
//            'description' => $request->input('reason')
//        ]);

//        (new IncreaseAvailableQuantity())->execute($inventory, (float) $request->input('quantity'));

        $createInventoryStockIn->execute(
            $inventory,
            null,
            (float) $request->input('quantity'),
            0,
            $request->input('reason')
        );

        return Redirect::route('inventory.show', ['materialInventory' => $inventory->id ]);
    }
}

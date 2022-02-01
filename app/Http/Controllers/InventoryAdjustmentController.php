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
    public function store(
        CreateInventoryStockIn $createInventoryStockIn,
        MaterialInventory $inventory,
        Request $request
    ) {
        try {
            $createInventoryStockIn->execute(
                $inventory,
                null,
                (float)$request->input('quantity'),
                0,
                $request->input('reason')
            );

            return Redirect::route('inventory.show', ['materialInventory' => $inventory->id])
                ->with(['message' => 'successfully saved']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}

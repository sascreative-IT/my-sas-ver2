<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\Inventory\Actions\CreateInventoryStockIn;
use App\Domains\Inventory\Actions\IncreaseAvailableQuantity;
use App\Models\InventoryIn;
use App\Models\MaterialInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class InventoryAdjustmentController
{
    public function store(
        CreateInventoryStockIn $createInventoryStockIn,
        MaterialInventory $inventory,
        Request $request
    ) {
        try {

            $validator = Validator::make($request->all(), [
                'quantity' => 'required|numeric|not_in:0',
                'reason' => 'required'
            ]);

            if ($validator->fails()) {
                Session::flash('message', $validator->messages()->first());
                return back()->withInput()->withErrors(['message' => $validator->messages()->first()]);
            }

            $createInventoryStockIn->execute(
                $inventory,
                null,
                (float)$request->input('quantity'),
                null,
                auth()->user()->id,
                $request->input('reason')
            );

            Session::flash('message', 'Stock adjusted successfully');
            return Redirect::route('inventory.show', ['materialInventory' => $inventory->id])
                ->with(['message', 'Stock adjusted successfully']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}

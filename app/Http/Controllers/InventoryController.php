<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Factory;
use App\Models\InventoryIn;
use App\Models\InventoryReserv;
use App\Models\MaterialInventory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $factories = Factory::all()->toArray();

        if (!$request->has('factory')) {
            return redirect()->route('inventory.index', ['factory' => 1]);
        }

        return Inertia::render('Inventory/InventoryIndex',
            [
                'factories' => $factories,
                'inventory' => MaterialInventory::with(['variation.material', 'variation.colour'])
                    ->where('factory_id','=',$request->get('factory'))
                    ->paginate(15)
                    ->withQueryString()
                    ->through(function ($inventory) {
                        return [
                            'id' => $inventory->id,
                            'unit' => $inventory->unit,
                            'available_quantity' => $inventory->available_quantity,
                            'allocated_quantity' => $inventory->allocated_quantity,
                            'usable_quantity' => $inventory->usable_quantity,
                            'factory_id' => $inventory->factory_id,
                            'material_name' => $inventory->variation->material->name,
                            'color_name' => $inventory->variation->colour->name,
                        ];
                    }),
            ]
        );
    }

    public function show(MaterialInventory $materialInventory, Request $request)
    {
        return Inertia::render('Inventory/InventoryShow',
            [
                'inventory' => $materialInventory->loadMissing(['variation.material', 'variation.colour']),
                'stockIn' => InventoryIn::where('material_inventory_id','=',$materialInventory->id)
                    ->with('invoice')
                    ->paginate(15)
                    ->withQueryString(),
                'stockReserv' => InventoryReserv::where('material_inventory_id','=',$materialInventory->id)
                    ->with('order')
                    ->paginate(15)
                    ->withQueryString()
            ]
        );
    }
}

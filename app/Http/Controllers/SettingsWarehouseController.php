<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;

class SettingsWarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::with('country')->get();

        return Inertia::render(
            'Settings/Warehouse',
            [
                'warehouses' => $warehouses
            ]
        );
    }

    public function create()
    {
        $countries = Country::all();

        return Inertia::render(
            'Settings/Warehouses/WarehouseAdd',
            ['countries' => $countries],
        );
    }

    public function store(StoreWarehouseRequest $request)
    {
        try {
            $validated = $request->validated();
            Warehouse::create($validated);

            return Redirect::route('settings.warehouses.index')
                ->with(['message' => 'successfully saved']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function edit(Warehouse $warehouse)
    {
        $countries = Country::all();

        return Inertia::render(
            'Settings/Warehouses/WarehouseUpdate',
            [
                'countries' => $countries,
                'initWarehouse' => $warehouse
            ],
        );
    }

    public function update(Warehouse $warehouse, UpdateWarehouseRequest $request)
    {
        try {
            $validated = $request->validated();
            $warehouse->update($validated);

            return Redirect::route('settings.warehouses.index')
                ->with(['message' => 'successfully saved']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function delete(Warehouse $warehouse)
    {
        try {
            $warehouse->delete();

            return Redirect::route('settings.warehouses.index')
                ->with(['message' => 'successfully deleted']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}

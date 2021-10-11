<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Country;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Http\Requests\StoreOutletRequest;
use App\Http\Requests\UpdateOutletRequest;

class SettingsOutletController extends Controller
{
    public function index()
    {
        $outlets = Outlet::with('country')->get();

        return Inertia::render(
            'Settings/Outlets/Outlets',
            [
                'outlets' => $outlets
            ]
        );
    }

    public function create()
    {
        $countries = Country::all();

        return Inertia::render(
            'Settings/Outlets/OutletAdd',
            ['countries' => $countries],
        );
    }

    public function store(StoreOutletRequest $request)
    {
        $validated = $request->validated();
        Outlet::create($validated);

        return Redirect::route('settings.outlets.index');
    }

    public function edit(Outlet $outlet)
    {
        $countries = Country::all();

        return Inertia::render(
            'Settings/Outlets/OutletUpdate',
            [
                'countries' => $countries,
                'initOutlet' => $outlet
            ],
        );
    }

    public function update(Outlet $outlet, UpdateOutletRequest $request)
    {
        $validated = $request->validated();
        $outlet->update($validated);

        return Redirect::route('settings.outlets.index');
    }

    public function delete(Outlet $outlet)
    {
        $outlet->delete();

        return Redirect::route('settings.outlets.index');
    }

}

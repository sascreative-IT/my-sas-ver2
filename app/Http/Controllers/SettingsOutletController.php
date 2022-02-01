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
        try {
            $validated = $request->validated();
            Outlet::create($validated);

            return Redirect::route('settings.outlets.index')
                ->with(['message' => 'successfully saved']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
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
        try {
            $validated = $request->validated();
            $outlet->update($validated);

            return Redirect::route('settings.outlets.index')
                ->with(['message' => 'successfully saved']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function delete(Outlet $outlet)
    {
        try {
            $outlet->delete();

            return Redirect::route('settings.outlets.index')
                ->with(['message' => 'successfully deleted']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

}

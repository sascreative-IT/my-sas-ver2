<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Factory;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Http\Requests\StoreFactoryRequest;

class SettingsFactoryController extends Controller
{
    public function index()
    {
        $factories = Factory::query()
            ->with('country')
            ->get();

        return Inertia::render(
            'Settings/Factories',
            [
                'factories' => $factories
            ]
        );
    }

    public function create()
    {
        $countries = Country::all();

        return Inertia::render(
            'Settings/Factory/FactoryAdd',
            ['countries' => $countries],
        );
    }

    public function store(StoreFactoryRequest $request)
    {
        try {
            $validated = $request->validated();
            Factory::create($validated);

            return Redirect::route('settings.factories.index')
                ->with(['message' => 'successfully updated']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function edit(Factory $factory)
    {
        $countries = Country::all();

        return Inertia::render(
            'Settings/Factory/FactoryEdit',
            [
                'countries' => $countries,
                'factory' => $factory
            ],
        );
    }

    public function update(Factory $factory, StoreFactoryRequest $request)
    {
        try {
            $validated = $request->validated();
            $factory->update($validated);

            return Redirect::route('settings.factories.index')
                ->with(['message' => 'The record successfully updated.']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function delete(Factory $factory)
    {
        try {
            $factory->delete();
            return Redirect::route('settings.factories.index')
                ->with(['message' => 'The record successfully deleted.']);
        } catch (\Exception $ex) {
            return Redirect::route('settings.factories.index')
                ->with(['message' => 'The factory is already in use and it cannot be deleted.']);
        }

    }
}

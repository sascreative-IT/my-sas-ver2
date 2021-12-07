<?php
declare(strict_types = 1);

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
            'Settings/FactoryAdd',
            ['countries' => $countries],
        );
    }

    public function store(StoreFactoryRequest $request)
    {
        $validated = $request->validated();
        Factory::create($validated);

        return Redirect::route('settings.factories.index')
            ->with(['message' => 'successfully updated']);
    }
}

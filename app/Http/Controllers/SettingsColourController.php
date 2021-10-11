<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreColourRequest;
use App\Http\Requests\UpdateColourRequest;
use App\Models\Colour;
use App\Models\MaterialType;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SettingsColourController extends Controller
{
    public function index()
    {
        $colours = Colour::query()
            ->with('type')
            ->get();

        return Inertia::render(
            'Settings/Colours/ColoursIndex',
            [
                'colours' => $colours
            ]
        );
    }

    public function create()
    {
        $materialTypes = MaterialType::all();

        return Inertia::render(
            'Settings/Colours/Create',
            ['materialTypes' => $materialTypes],
        );
    }

    public function store(StoreColourRequest $request)
    {
        $validated = $request->validated();
        Colour::create($validated);

        return Redirect::route('settings.colours.index');
    }

    public function edit(Colour $colour)
    {
        $materialTypes = MaterialType::all();

        return Inertia::render(
            'Settings/Colours/Update',
            [
                'materialTypes' => $materialTypes,
                'initColour' => $colour
            ],
        );
    }

    public function update(Colour $colour, UpdateColourRequest $request)
    {
        $validated = $request->validated();
        $colour->update($validated);

        return Redirect::route('settings.colours.index');
    }

    public function delete(Colour $colour)
    {
        $colour->delete();

        return Redirect::route('settings.colours.index');
    }
}

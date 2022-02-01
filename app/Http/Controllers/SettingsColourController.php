<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreColourRequest;
use App\Http\Requests\UpdateColourRequest;
use App\Models\Colour;
use App\Models\MaterialType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SettingsColourController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $colours = Colour::query()
            ->with('type')
            ->when($q, function ($query, $q) {
                return $query
                    ->where('name', 'like', "%{$q}%");
            })
            ->paginate()
            ->withQueryString();

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
        try {
            $validated = $request->validated();
            Colour::create($validated);

            return Redirect::route('settings.colours.index');
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
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
        try {
            $validated = $request->validated();
            $colour->update($validated);

            return Redirect::route('settings.colours.index')
                ->with(['message' => 'successfully saved']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function delete(Colour $colour)
    {
        try {
            $colour->delete();

            return Redirect::route('settings.colours.index')
                ->with(['message' => 'successfully deleted']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}

<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Materials;
use App\Models\MaterialType;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SettingsMaterialController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $materials = Materials::query()
            ->when($q, function ($query, $q) {
                return $query
                    ->where('name', 'like', "%{$q}%")
                    ->orWhere('type', 'like', "%{$q}%");
            })
            ->paginate()
            ->withQueryString();

        return Inertia::render(
            'Settings/Materials/MaterialsIndex',
            [
                'materials' => $materials,
                'q' => $q
            ]
        );
    }

    public function create()
    {
        $materialTypes = MaterialType::all();
        $units = Unit::all();
        return Inertia::render(
            'Settings/Materials/MaterialsCreate',
            [
                'units' => $units,
                'material_types' => $materialTypes,
                'materials' => []
            ]
        );
    }

    public function store(Request $request)
    {
        Materials::create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'unit' => $request->input('unit'),
            'fiber_content' => $request->input('fiber_content'),
        ]);

        return Redirect::route('settings.materials.index');
    }

    public function edit(Materials $materials)
    {
        $materialTypes = MaterialType::all();
        $units = Unit::all();
        return Inertia::render(
            'Settings/Materials/MaterialsEdit',
            [
                'units' => $units,
                'material_types' => $materialTypes,
                'material' => $materials
            ]
        );
    }

    public function update(Materials $materials, Request $request)
    {
        $materials->update([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'unit' => $request->input('unit'),
            'fiber_content' => $request->input('fiber_content'),
        ]);

        return Redirect::route('settings.materials.index');
    }

    public function delete(Materials $materials)
    {
        if ($materials->marked_as_not_in_use) {
            $materials->update(['marked_as_not_in_use' => null]);
        } else {
            $materials->update(['marked_as_not_in_use' => now()]);
        }
        return Redirect::route('settings.materials.index');
    }
}

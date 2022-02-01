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
        try {
            Materials::create([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'unit' => $request->input('unit'),
                'fiber_content' => $request->input('fiber_content'),
            ]);

            return Redirect::route('settings.materials.index')
                ->with(['message' => 'The record successfully updated.']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
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
        try {
            $materials->update([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'unit' => $request->input('unit'),
                'fiber_content' => $request->input('fiber_content'),
            ]);

            return Redirect::route('settings.materials.index')
                ->with(['message' => 'The record successfully updated.']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function delete(Materials $materials)
    {
        try {
            $materials->delete();
            return Redirect::route('settings.materials.index')
                ->with(['message' => 'The record successfully deleted.']);
        } catch (\Exception $ex) {
            return Redirect::route('settings.materials.index')
                ->with(['message' => 'The material is already in use and it cannot be deleted.']);
        }

    }
}

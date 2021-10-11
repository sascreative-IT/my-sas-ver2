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
    public function index()
    {
        $materials = Materials::all();

        return Inertia::render(
            'Settings/Materials/MaterialsIndex',
            [
                'materials' => $materials
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
}

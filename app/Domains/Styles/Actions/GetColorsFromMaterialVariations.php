<?php

namespace App\Domains\Styles\Actions;

use App\Models\Colour;
use App\Models\MaterialVariation;
use Illuminate\Http\Request;

class GetColorsFromMaterialVariations
{
    public function execute(Request $requestWithMaterial)
    {
        $colours = '';

        if ($requestWithMaterial->filled('material_id')) {
            $material_id = $requestWithMaterial->get('material_id');
            $colourIds = collect(
                MaterialVariation::query()
                    ->where('material_id', $material_id)
                    ->get()
            )->pluck('colour_id')->toArray();
            $colours = Colour::query()->whereIn('id', $colourIds)->get();
        }

        return $colours;
    }
}

<?php
declare(strict_types=1);

namespace App\Domains\Styles\Actions;

use App\Models\Style;
use Illuminate\Support\Facades\DB;

class GetAvailableMaterialColors
{
    public function execute($style)
    {
        $materialIds = [];

        foreach($style->panels as $panel){
            $materialIds[] = $panel->fabrics[0]->id;
        }

        return DB::table('material_variations')
            ->join('material_inventories', function ($join) use ($materialIds) {
                $join->on('material_variations.id', '=', 'material_inventories.material_variation_id')
                    ->whereIn('material_variations.material_id', $materialIds);
            })
            ->join('colours', 'material_variations.colour_id', '=', 'colours.id')
            ->groupBy('colours.id')
            ->select('colours.*')
            ->get();
    }
}

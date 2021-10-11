<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\MaterialVariation;
use Illuminate\Database\Eloquent\Collection;

class MaterialVariationRepository
{
    public function getAllFabricsWithSuppliers($factoryIds = []): Collection
    {
        return MaterialVariation::with(['suppliers' => function ($query) use($factoryIds) {
            if (count($factoryIds) > 0) {
                $query->whereIn('material_suppliers.factory_id', $factoryIds);
            }

            return $query;
        }])->get();
    }
}

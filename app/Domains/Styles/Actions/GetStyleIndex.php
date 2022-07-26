<?php

namespace App\Domains\Styles\Actions;

use App\Models\CustomizedStyle;
use App\Models\NewCustomizedStyle;

class GetStyleIndex
{

    public function execute(CustomizedStyle|NewCustomizedStyle $styleType, string $belongTo, string $searchTerm = '')
    {
        $getStyleWithBelongColumn = $this->getBelongToValue($styleType, $belongTo);

        if (!$getStyleWithBelongColumn) {
            abort(404);
        }

        return $getStyleWithBelongColumn
            ->with('itemType')
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query
                    ->where('code', 'like', "%{$searchTerm}%")
                    ->orWhere('name', 'like', "%{$searchTerm}%");
            })
            ->paginate()
            ->withQueryString();
    }

    private function getBelongToValue($styleType, $type)
    {
        if ($type == 'internal' || $type == 'external') {
            return $styleType->query()->$type();
        } else {
            return false;
        }
    }

}

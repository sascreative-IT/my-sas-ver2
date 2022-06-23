<?php

namespace App\Domains\Styles\Actions;

use App\Domains\Styles\Dto\Factories as FactoriesDto;
use App\Domains\Styles\Dto\Factory as FactoryDto;
use App\Models\Style;

class AttachFactoriesToCustomStyle
{
    public function execute(Style $style, array $factories): void
    {
        $collection = collect($factories);
        $plucked = $collection->pluck('id');

         $style->factories()->sync($plucked->all());
    }
}

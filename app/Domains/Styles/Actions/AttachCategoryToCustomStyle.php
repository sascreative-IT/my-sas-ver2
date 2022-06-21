<?php

namespace App\Domains\Styles\Actions;

use App\Models\Style;

class AttachCategoryToCustomStyle
{
    public function execute(Style $style, array $category): void
    {
        $collection = collect($category);
        $plucked = $collection->pluck('id');

        $style->categories()->sync($plucked->all());
    }
}

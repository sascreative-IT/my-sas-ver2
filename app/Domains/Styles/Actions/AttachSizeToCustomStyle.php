<?php
namespace App\Domains\Styles\Actions;

use App\Models\Style;

class AttachSizeToCustomStyle
{
    public function execute(Style $style, array $sizes): void
    {
        $collection = collect($sizes);
        $plucked = $collection->pluck('id');

        $style->sizes()->sync($plucked->all());
    }
}

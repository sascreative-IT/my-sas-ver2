<?php
declare(strict_types=1);

namespace App\Domains\Styles\Actions;

use App\Domains\Styles\Dto\Size as SizeDto;
use App\Models\Style;

class AttachSizeToStyle
{
    public function execute(Style $style, SizeDto $size): void
    {
        $style->sizes()->syncWithoutDetaching([$size->id]);
    }
}

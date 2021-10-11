<?php
declare(strict_types=1);

namespace App\Domains\Styles\Actions;

use App\Domains\Styles\Dto\Category as CategoryDto;
use App\Models\Style;

class AttachCategoryToStyle
{
    public function execute(Style $style, CategoryDto $category): void
    {
        $style->categories()->syncWithoutDetaching($category->id);
    }
}

<?php
declare(strict_types=1);

namespace App\Domains\Styles\Actions;

use App\Domains\Styles\Dto\Factory as FactoryDto;
use App\Models\Style;
use Tests\TestCase;

class AttachFactoriesToStyle
{
    public function execute(Style $style, FactoryDto $factory): void
    {
        $style->factories()->syncWithoutDetaching([$factory->id]);
    }
}

<?php
declare(strict_types=1);

namespace App\Domains\Styles\Dto;

use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class Panel extends DataTransferObject
{
    public ?int $id;
    public ?string $name;
    public ?Fabric $default_fabric;

    /** @var \App\Domains\Styles\Dto\Consumption[] */
    #[CastWith(ConsumptionCaster::class)]
    public ?array $consumption;

    /** @var \App\Domains\Styles\Dto\Fabric[] */
    #[CastWith(FabricCaster::class)]
    public ?array $fabrics;

    public ?\App\Domains\Styles\Dto\Color $color;
}

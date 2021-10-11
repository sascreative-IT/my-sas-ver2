<?php
declare(strict_types=1);

namespace App\Domains\Styles\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class Size extends DataTransferObject
{
    public ?int $id;
    public ?string $name;
    public ?string $slug;
}

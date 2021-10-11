<?php
declare(strict_types=1);

namespace App\Domains\Styles\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class Consumption extends DataTransferObject
{
    public ?int $id;
    public ?Size $size;
    public ?float $amount;
}

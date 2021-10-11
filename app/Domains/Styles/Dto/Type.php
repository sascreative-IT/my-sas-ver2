<?php
declare(strict_types=1);

namespace App\Domains\Styles\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class Type extends DataTransferObject
{
    public int $id;
    public string $name;
}

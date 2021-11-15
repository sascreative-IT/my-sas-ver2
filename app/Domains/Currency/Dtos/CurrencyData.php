<?php

namespace App\Domains\Currency\Dtos;

use Spatie\DataTransferObject\DataTransferObject;

class CurrencyData extends DataTransferObject
{
    public function __construct(
        public string $name,
        public ?float $rate = 1
    ) {
    }
}

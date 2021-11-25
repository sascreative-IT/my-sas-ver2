<?php

namespace App\Domains\Currency\Dtos;

use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class CurrencyData extends DataTransferObject
{
    public function __construct(
        public string $name,
        public string $status
    ) {
    }
}

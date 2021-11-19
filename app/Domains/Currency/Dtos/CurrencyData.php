<?php

namespace App\Domains\Currency\Dtos;

use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class CurrencyData extends DataTransferObject
{
    public Carbon $rateOn;
    public float $rate;

    public function __construct(
        public string $name,
        public string $currencyRate,
        public string $currencyRateOn,
    ) {
        $this->rateOn = Carbon::parse($currencyRateOn);
        $this->rate = (float)$currencyRate;
    }
}

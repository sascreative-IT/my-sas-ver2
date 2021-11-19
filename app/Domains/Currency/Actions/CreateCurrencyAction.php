<?php

namespace App\Domains\Currency\Actions;

use App\Domains\Currency\Dtos\CurrencyData;
use App\Domains\Currency\Models\CurrencyExchangeRate;

class CreateCurrencyAction
{
    public function execute(CurrencyData $currencyData)
    {
        return CurrencyExchangeRate::create([
            'name' => $currencyData->name,
            'rate' => $currencyData->rate,
            'rate_on' => $currencyData->currencyRateOn
        ]);
    }
}

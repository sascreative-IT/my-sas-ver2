<?php

namespace App\Domains\Currency\Actions;

use App\Domains\Currency\Dtos\CurrencyExchangeRateData;
use App\Domains\Currency\Models\CurrencyExchangeRate;

class CreateCurrencyExchangeRateAction
{
    public function execute(CurrencyExchangeRateData $currencyData)
    {
        return CurrencyExchangeRate::create([
            'name' => $currencyData->name,
            'rate' => $currencyData->rate,
            'rate_on' => $currencyData->currencyRateOn
        ]);
    }
}

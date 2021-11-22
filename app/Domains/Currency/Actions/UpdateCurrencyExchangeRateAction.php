<?php

namespace App\Domains\Currency\Actions;

use App\Domains\Currency\Dtos\CurrencyExchangeRateData;
use App\Domains\Currency\Models\CurrencyExchangeRate;

class UpdateCurrencyExchangeRateAction
{
    public function execute(CurrencyExchangeRateData $currencyData, CurrencyExchangeRate $currency): CurrencyExchangeRate
    {
        $currency->update([
            'name' => $currencyData->name,
            'rate' => $currencyData->rate,
            'rate_on' => $currencyData->currencyRateOn
        ]);

        return $currency;
    }
}

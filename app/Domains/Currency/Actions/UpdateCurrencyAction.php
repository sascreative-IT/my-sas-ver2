<?php

namespace App\Domains\Currency\Actions;

use App\Domains\Currency\Dtos\CurrencyData;
use App\Domains\Currency\Models\Currency;

class UpdateCurrencyAction
{
    public function execute(CurrencyData $currencyData, Currency $currency): Currency
    {
        $currency->update([
            'name' => $currencyData->name,
            'rate' => $currencyData->rate,
            'rate_on' => $currencyData->currencyRateOn
        ]);

        return $currency;
    }
}

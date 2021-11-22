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
            'status' => $currencyData->status
        ]);

        return $currency;
    }
}

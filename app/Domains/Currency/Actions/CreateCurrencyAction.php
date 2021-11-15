<?php

namespace App\Domains\Currency\Actions;

use App\Domains\Currency\Dtos\CurrencyData;
use App\Domains\Currency\Models\Currency;

class CreateCurrencyAction
{
    public function execute(CurrencyData $currencyData)
    {
        return Currency::create([
            'name' => $currencyData->name,
            'rate' => $currencyData->rate,
        ]);
    }
}

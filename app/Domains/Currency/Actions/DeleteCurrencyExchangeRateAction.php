<?php

namespace App\Domains\Currency\Actions;

use App\Domains\Currency\Dtos\CurrencyExchangeRateData;
use App\Domains\Currency\Models\CurrencyExchangeRate;

class DeleteCurrencyExchangeRateAction
{
    public function execute(CurrencyExchangeRate $currency): bool
    {
        return $currency->delete();
    }
}

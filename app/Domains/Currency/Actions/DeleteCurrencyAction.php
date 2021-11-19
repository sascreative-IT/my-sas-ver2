<?php

namespace App\Domains\Currency\Actions;

use App\Domains\Currency\Dtos\CurrencyData;
use App\Domains\Currency\Models\CurrencyExchangeRate;

class DeleteCurrencyAction
{
    public function execute(CurrencyExchangeRate $currency): bool
    {
        return $currency->delete();
    }
}

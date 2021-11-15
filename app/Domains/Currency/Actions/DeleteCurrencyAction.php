<?php

namespace App\Domains\Currency\Actions;

use App\Domains\Currency\Dtos\CurrencyData;
use App\Domains\Currency\Models\Currency;

class DeleteCurrencyAction
{
    public function execute(Currency $currency): bool
    {
        return $currency->delete();
    }
}

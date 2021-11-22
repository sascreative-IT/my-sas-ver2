<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\Currency\Actions\CreateCurrencyExchangeRateAction;
use App\Domains\Currency\Actions\DeleteCurrencyExchangeRateAction;
use App\Domains\Currency\Actions\UpdateCurrencyExchangeRateAction;
use App\Domains\Currency\Dtos\CurrencyExchangeRateData;
use App\Domains\Currency\Models\CurrencyExchangeRate;
use App\Http\Requests\StoreCurrencyRequest;
use App\Models\Country;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;

class SettingsCurrencyExchangeRateController extends Controller
{
    public function index(): \Inertia\Response
    {
        $currencyExchangeRates = CurrencyExchangeRate::query()->get();

        return Inertia::render(
            'Settings/CurrencyExchangeRate',
            [
                'currencyExchangeRates' => $currencyExchangeRates
            ]
        );
    }

    public function create()
    {
        return Inertia::render(
            'Settings/CurrencyExchangeRate/CurrencyExchangeRateAdd',
        );
    }

    public function store(StoreCurrencyRequest $request): \Illuminate\Http\RedirectResponse
    {
        $currencyData = new CurrencyExchangeRateData(...$request->validated());
        (new CreateCurrencyExchangeRateAction())->execute($currencyData);

        return Redirect::route('settings.currency-exchange-rates.index');
    }

    public function edit(CurrencyExchangeRate $currencyExchangeRate)
    {
        return Inertia::render(
            'Settings/CurrencyExchangeRate/CurrencyExchangeRateUpdate',
            [
                'currencyExchangeRate' => $currencyExchangeRate
            ],
        );
    }

    public function update(CurrencyExchangeRate $currencyExchangeRate, StoreCurrencyRequest $request)
    {
        $currencyExchangeRateData = new CurrencyExchangeRateData(...$request->validated());
        (new UpdateCurrencyExchangeRateAction())->execute($currencyExchangeRateData, $currencyExchangeRate);

        return Redirect::route('settings.currency-exchange-rates.index');
    }

    public function delete(CurrencyExchangeRate $currencyExchangeRate)
    {
        (new DeleteCurrencyExchangeRateAction())->execute($currencyExchangeRate);

        return Redirect::route('settings.currency-exchange-rates.index');
    }
}

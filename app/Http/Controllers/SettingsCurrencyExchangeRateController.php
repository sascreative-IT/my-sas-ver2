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
        $currencies = CurrencyExchangeRate::query()->get();

        return Inertia::render(
            'Settings/Currency',
            [
                'currencies' => $currencies
            ]
        );
    }

    public function create()
    {
        return Inertia::render(
            'Settings/Currency/CurrencyAdd',
        );
    }

    public function store(StoreCurrencyRequest $request): \Illuminate\Http\RedirectResponse
    {
        $currencyData = new CurrencyExchangeRateData(...$request->validated());
        (new CreateCurrencyExchangeRateAction())->execute($currencyData);

        return Redirect::route('settings.currencies.index');
    }

    public function edit(CurrencyExchangeRate $currency)
    {
        return Inertia::render(
            'Settings/Currency/CurrencyUpdate',
            [
                'currency' => $currency
            ],
        );
    }

    public function update(CurrencyExchangeRate $currency, StoreCurrencyRequest $request)
    {
        $currencyData = new CurrencyExchangeRateData(...$request->validated());
        (new UpdateCurrencyExchangeRateAction())->execute($currencyData, $currency);

        return Redirect::route('settings.currencies.index');
    }

    public function delete(CurrencyExchangeRate $currency)
    {
        (new DeleteCurrencyExchangeRateAction())->execute($currency);

        return Redirect::route('settings.currencies.index');
    }
}

<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\Currency\Actions\CreateCurrencyAction;
use App\Domains\Currency\Actions\CreateCurrencyExchangeRateAction;
use App\Domains\Currency\Actions\DeleteCurrencyAction;
use App\Domains\Currency\Actions\DeleteCurrencyExchangeRateAction;
use App\Domains\Currency\Actions\UpdateCurrencyAction;
use App\Domains\Currency\Actions\UpdateCurrencyExchangeRateAction;
use App\Domains\Currency\Dtos\CurrencyData;
use App\Domains\Currency\Dtos\CurrencyExchangeRateData;
use App\Domains\Currency\Models\Currency;
use App\Domains\Currency\Models\CurrencyExchangeRate;
use App\Http\Requests\StoreCurrencyRequest;
use App\Models\Country;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;

class SettingsCurrencyController extends Controller
{
    public function index(): \Inertia\Response
    {
        $currencies = Currency::query()->get();

        return Inertia::render(
            'Settings/Currency',
            [
                'currencies' => $currencies
            ]
        );
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render(
            'Settings/Currency/CurrencyAdd',
        );
    }

    public function store(StoreCurrencyRequest $request): \Illuminate\Http\RedirectResponse
    {
        $currencyData = new CurrencyData(...$request->validated());
        (new CreateCurrencyAction())->execute($currencyData);

        return Redirect::route('settings.currencies.index');
    }

    public function edit(Currency $currency)
    {
        return Inertia::render(
            'Settings/Currency/CurrencyUpdate',
            [
                'currency' => $currency
            ],
        );
    }

    public function update(Currency $currency, StoreCurrencyRequest $request)
    {
        $currencyData = new CurrencyData(...$request->validated());
        (new UpdateCurrencyAction())->execute($currencyData, $currency);

        return Redirect::route('settings.currencies.index');
    }

    public function delete(Currency $currency)
    {
        (new DeleteCurrencyAction())->execute($currency);

        return Redirect::route('settings.currencies.index');
    }
}

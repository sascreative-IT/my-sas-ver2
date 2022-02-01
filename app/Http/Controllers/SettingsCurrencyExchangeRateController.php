<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\Currency\Actions\CreateCurrencyExchangeRateAction;
use App\Domains\Currency\Actions\DeleteCurrencyExchangeRateAction;
use App\Domains\Currency\Actions\UpdateCurrencyExchangeRateAction;
use App\Domains\Currency\Dtos\CurrencyExchangeRateData;
use App\Domains\Currency\Models\Currency;
use App\Domains\Currency\Models\CurrencyExchangeRate;
use App\Http\Requests\StoreCurrencyExchangeRequest;
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
        $currencies = Currency::query()->get();

        return Inertia::render(
            'Settings/CurrencyExchangeRate/CurrencyExchangeRateAdd',
            [
                'currencies' => $currencies
            ]
        );
    }

    public function store(StoreCurrencyExchangeRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $currencyData = new CurrencyExchangeRateData(...$request->validated());
            (new CreateCurrencyExchangeRateAction())->execute($currencyData);

            return Redirect::route('settings.currency-exchange-rates.index')
                ->with(['message' => 'successfully saved']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function edit(CurrencyExchangeRate $currencyExchangeRate)
    {
        $currencies = Currency::query()->get();

        return Inertia::render(
            'Settings/CurrencyExchangeRate/CurrencyExchangeRateUpdate',
            [
                'currencyExchangeRate' => $currencyExchangeRate,
                'currencies' => $currencies
            ],
        );
    }

    public function update(CurrencyExchangeRate $currencyExchangeRate, StoreCurrencyExchangeRequest $request)
    {
        try {
            $currencyExchangeRateData = new CurrencyExchangeRateData(...$request->validated());
            (new UpdateCurrencyExchangeRateAction())->execute($currencyExchangeRateData, $currencyExchangeRate);

            return Redirect::route('settings.currency-exchange-rates.index')
                ->with(['message' => 'successfully saved']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function delete(CurrencyExchangeRate $currencyExchangeRate)
    {
        try {
            (new DeleteCurrencyExchangeRateAction())->execute($currencyExchangeRate);

            return Redirect::route('settings.currency-exchange-rates.index')
                ->with(['message' => 'successfully deleted']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}

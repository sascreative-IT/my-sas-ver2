<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\Currency\Actions\CreateCurrencyAction;
use App\Domains\Currency\Actions\DeleteCurrencyAction;
use App\Domains\Currency\Actions\UpdateCurrencyAction;
use App\Domains\Currency\Dtos\CurrencyData;
use App\Domains\Currency\Models\Currency;
use App\Http\Requests\StoreCurrencyExchangeRequest;
use App\Http\Requests\StoreCurrencyRequest;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

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
        try {
            $currencyData = new CurrencyData(...$request->validated());
            (new CreateCurrencyAction())->execute($currencyData);

            return Redirect::route('settings.currencies.index')
                ->with(['message' => 'successfully saved']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
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
        try {
            $currencyData = new CurrencyData(...$request->validated());
            (new UpdateCurrencyAction())->execute($currencyData, $currency);

            return Redirect::route('settings.currencies.index')
                ->with(['message' => 'successfully saved']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function delete(Currency $currency)
    {
        (new DeleteCurrencyAction())->execute($currency);

        return Redirect::route('settings.currencies.index');
    }
}

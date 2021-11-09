<?php

namespace App\Http\Controllers;

use App\Domains\Invoices\Actions\CreateInvoices;
use App\Domains\Invoices\Dtos\Invoice;
use App\Domains\Invoices\Dtos\InvoiceItem;
use App\Domains\PurchaseOrder\Actions\CreatePurchaseOrderAction;
use App\Domains\PurchaseOrder\Dtos\PurchaseOrderData;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Domains\Stock\Actions\CreateStockOutAction;
use App\Domains\Stock\Dtos\StockOutData;
use App\Http\Requests\PurchaseOrder\StorePurchaseOrderRequest;
use App\Http\Requests\StockOut\StockOutRequest;
use App\Models\Colour;
use App\Models\Customer;
use App\Models\Factory;
use App\Models\MaterialInvoice;
use App\Models\Materials;
use App\Models\Order;
use App\Models\Style;
use App\Models\StylePanel;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use App\Repositories\StyleCodeRepository;
use Doctrine\DBAL\Exception\DatabaseObjectExistsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Services\Models\ModelToSelectOptionsFacade as SelectOptions;

class StockOutController extends Controller
{
    protected $styleCodeRepository;

    public function __construct(StyleCodeRepository $styleCodeRepository)
    {
        $this->styleCodeRepository = $styleCodeRepository;
    }

    public function create(Request $request)
    {
        $factories = Factory::query()->get();
        $materials = Materials::query()->get();
        $colours = Colour::query()->get();
        $customers = Customer::query()->get();

        $styles = $this->styleCodeRepository->getAll();
        $style_panels = [];

        if ($request->filled('style_id')) {
            $style_id = $request->get('style_id');
            $style_panels = StylePanel::where('style_id', $style_id)->get();
        }

        return Inertia::render('StockOut/Create', [
            'factories' => $factories,
            'styles' => $styles,
            'style_panels' => $style_panels,
            'materials' => $materials,
            'colours' => $colours,
            'customers' => $customers
        ]);
    }

    public function store(
        CreateStockOutAction $stockOutAction,
        StockOutRequest      $stockOutRequest
    )
    {
        $stockOutData = StockOutData::fromRequest($stockOutRequest);

        $stockOutAction->execute($stockOutData);
        return Redirect::route('inventory.index')
            ->with('success', 'Record has been saved successfully.');
    }
}

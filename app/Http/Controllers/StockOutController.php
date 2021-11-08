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
use App\Models\Factory;
use App\Models\MaterialInvoice;
use App\Models\Materials;
use App\Models\Supplier;
use App\Models\Unit;
use Doctrine\DBAL\Exception\DatabaseObjectExistsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Services\Models\ModelToSelectOptionsFacade as SelectOptions;

class StockOutController extends Controller
{
    public function create()
    {
        return Inertia::render('StockOut/Create');
    }

    public function store(
        CreateStockOutAction $stockOutAction,
        StockOutRequest $stockOutRequest
    )
    {
        $stockOutData = StockOutData::fromRequest($stockOutRequest);

        $stockOutAction->execute($stockOutData);
        return Redirect::route('stock.out.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Domains\Invoices\Actions\CreateInvoices;
use App\Domains\Invoices\Dtos\Invoice;
use App\Domains\Invoices\Dtos\InvoiceItem;
use App\Domains\PurchaseOrder\Actions\CreatePurchaseOrderAction;
use App\Domains\PurchaseOrder\Dtos\PurchaseOrderData;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Http\Requests\PurchaseOrder\StorePurchaseOrderRequest;
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

class PurchaseOrderController extends Controller
{

    public function index(): \Inertia\Response
    {
        $purchase_orders = MaterialPurchaseOrder::query()->with(['supplier', 'factory', 'user'])
            ->orderBy("created_at", "DESC")
            ->paginate();

        return Inertia::render(
            'PurchaseOrder/Index',
            [
                'purchase_orders' => $purchase_orders
            ]
        );
    }

    public function create()
    {
        $factories = Factory::query()
            ->with('country')
            ->get();

        $materialsCollection = Materials::all();
        $materials = SelectOptions::selectOptionsObject($materialsCollection, 'id', 'name');

        $coloursCollection = Colour::all();
        $colours = SelectOptions::selectOptionsObject($coloursCollection, 'id', 'name');

        $supplierCollection = Supplier::all();
        $suppliers = SelectOptions::selectOptionsObject($supplierCollection, 'id', 'name');

        $unitCollection = Unit::all();
        $units = SelectOptions::selectOptionsObject($unitCollection, 'type', 'name');

        return Inertia::render(
            'PurchaseOrder/Create',
            [
                'factories' => $factories,
                'materials' => $materials,
                'colours' => $colours,
                'suppliers' => $suppliers,
                'units' => $units
            ]
        );
    }

    public function store(CreatePurchaseOrderAction $createPurchaseOrderAction, Request $request)
    {
        $purchaseOrderData = PurchaseOrderData::fromRequest(new StorePurchaseOrderRequest([
            'supplier_id' => $request->input('supplier_id'),
            'factory_id' => $request->input('factory_id'),
            'purchase_order_items' => $request->input('items')
        ]));

        $createPurchaseOrderAction->execute($purchaseOrderData);
        return Redirect::route('purchase.orders.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Domains\Currency\Models\Currency;
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

    public function index(Request $request): \Inertia\Response
    {
        $factory = $request->get('factory');

        $purchase_orders = MaterialPurchaseOrder::query()
            ->with(['supplier', 'assignedFactory', 'user'])
            ->when($factory, function ($query, $factory) {
                return $query->where('factory_id', $factory);
            })
            ->orderBy("created_at", "DESC")
            ->paginate();

        return Inertia::render(
            'PurchaseOrder/Index',
            [
                'purchase_orders' => $purchase_orders
            ]
        );
    }

    public function create(Request $request): \Inertia\Response
    {
        $materialsCollection = Materials::all();
        $materials = SelectOptions::selectOptionsObject($materialsCollection, 'id', 'name');

        $coloursCollection = Colour::all();
        $colours = SelectOptions::selectOptionsObject($coloursCollection, 'id', 'name');

        $supplierCollection = Supplier::all();
        $suppliers = SelectOptions::selectOptionsObject($supplierCollection, 'id', 'name');

        $unitCollection = Unit::all();
        $units = SelectOptions::selectOptionsObject($unitCollection, 'type', 'name');

        $factoryCollection = Factory::all();
        $factories = SelectOptions::selectOptionsObject($factoryCollection, 'id', 'name');

        $currencyCollection = Currency::all();
        $currencies = SelectOptions::selectOptionsObject($currencyCollection, 'id', 'name');

        $material = null;
        if ($request->filled('material_id')) {
            $material = Materials::find($request->get('material_id'));
        }


        return Inertia::render(
            'PurchaseOrder/Create',
            [
                'factories' => $factories,
                'materials' => $materials,
                'colours' => $colours,
                'suppliers' => $suppliers,
                'units' => $units,
                'currencies' => $currencies,
                'material' => $material
            ]
        );
    }

    public function store(
        CreatePurchaseOrderAction $createPurchaseOrderAction,
        StorePurchaseOrderRequest $purchaseOrderRequest
    ): \Illuminate\Http\RedirectResponse {

        $purchaseOrderData = PurchaseOrderData::fromRequest($purchaseOrderRequest);

        $createPurchaseOrderAction->execute($purchaseOrderData);
        return Redirect::route('purchase.orders.index');
    }
}

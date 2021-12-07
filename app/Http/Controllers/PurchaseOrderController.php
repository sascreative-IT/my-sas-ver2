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
        $status = $request->get('status');

        if (!$status) {
            $status = 'Pending';
        }

        $factories = Factory::all()->toArray();

        $purchase_orders = MaterialPurchaseOrder::query()
            ->with(['supplier', 'assignedFactory', 'user'])
            ->when($factory, function ($query, $factory) {
                return $query->where('factory_id', $factory);
            })
            ->when($status, function ($query, $status) {
                return $query->where('evaluation_status', $status);
            })
            ->orderBy("created_at", "DESC")
            ->paginate()
            ->appends($request->except(['page', '_token']));

        return Inertia::render(
            'PurchaseOrder/Index',
            [
                'purchase_orders' => $purchase_orders,
                'factories' => $factories,
                'status' => $status,
                'factory' => $factory
            ]
        );
    }

    public function create(Request $request): \Inertia\Response
    {
        $materials = Materials::all();
        $colours = Colour::all();
        $suppliers = Supplier::all();

        $unitCollection = Unit::all();
        $units = SelectOptions::selectOptionsObject($unitCollection, 'type', 'name');

        $factories = Factory::all();

        $currencies = Currency::all();

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

        return Redirect::route('purchase.orders.index')->with(['message' => 'successfully updated']);
    }
}

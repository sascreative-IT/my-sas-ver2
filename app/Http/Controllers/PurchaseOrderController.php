<?php

namespace App\Http\Controllers;

use App\Domains\Currency\Models\Currency;
use App\Domains\PurchaseOrder\Actions\CreatePurchaseOrderAction;
use App\Domains\PurchaseOrder\Dtos\PurchaseOrderData;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
use App\Http\Requests\PurchaseOrder\StorePurchaseOrderRequest;
use App\Models\Colour;
use App\Models\Factory;
use App\Models\MaterialInvoice;
use App\Models\Materials;
use App\Models\MaterialSupplier;
use App\Models\MaterialVariation;
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
        $materials = [];
        $colours = [];
        $suppliers = Supplier::all();

        $unitCollection = Unit::all();
        $units = SelectOptions::selectOptionsObject($unitCollection, 'type', 'name');

        $factories = Factory::all();

        $currencies = Currency::all();

        if ($request->filled('supplier_id')) {
            $suplier_materials = MaterialSupplier::with('variation','variation.material')->where("supplier_id", $request->get('supplier_id'))->get();
            $material_ids = [];
            foreach ($suplier_materials as $suplier_material) {
                if ($suplier_material->variation->material) {
                    array_push($material_ids, $suplier_material->variation->material->id);
                }
            }

            $materials = Materials::query()->whereIn("id", $material_ids)->get();
        }


        $material = null;
        if ($request->filled('material_id')) {
            $material = Materials::find($request->get('material_id'));
            $colorIds = MaterialVariation::where("material_id",$request->get('material_id'))
                ->pluck("colour_id")
                ->toArray();
            $colours = Colour::whereIn('id', $colorIds)->get();
        }

        $material_variations = null;
        if ($request->filled('material_id') && $request->filled('color_id')) {
            $material_variations = MaterialVariation::where("material_id",$request->get('material_id'))
            ->where("colour_id",$request->get('color_id'))
            ->first();
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
                'material' => $material,
                'material_variations' => $material_variations
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

    public function show(MaterialPurchaseOrder $purchase_order)
    {
        $purchase_order = MaterialPurchaseOrder::with('items','supplier','assignedFactory')->find($purchase_order->id);
        $materials = Materials::all();
        $colours = Colour::all();
        $suppliers = Supplier::all();

        $unitCollection = Unit::all();
        $units = SelectOptions::selectOptionsObject($unitCollection, 'type', 'name');

        $factories = Factory::all();

        $currencies = Currency::all();




        return Inertia::render(
            'PurchaseOrder/View',
            [
                'factories' => $factories,
                'materials' => $materials,
                'colours' => $colours,
                'suppliers' => $suppliers,
                'units' => $units,
                'currencies' => $currencies,
                'purchaseOrder' => $purchase_order
            ]
        );

    }
}

<?php

namespace App\Http\Controllers;

use App\Domains\Currency\Models\Currency;
use App\Domains\Invoices\Actions\CreateInvoices;
use App\Domains\Invoices\Dtos\Invoice;
use App\Domains\Invoices\Dtos\InvoiceItem;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
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

class InvoicesController extends Controller
{
    public function create(Request $request, MaterialPurchaseOrder $materialPurchaseOrder)
    {

        $factories = Factory::all();
        $materials = Materials::all();
        $colours = Colour::all();
        $suppliers = Supplier::all();

        $unitCollection = Unit::all();
        $units = SelectOptions::selectOptionsObject($unitCollection, 'type', 'name');

        $materialPurchaseOrder = MaterialPurchaseOrder::with(
            'items', 'assignedFactory', 'supplier'
            )
            ->find($materialPurchaseOrder->id);

        $currencies = Currency::all();

        $material = null;
        if ($request->filled('material_id')) {
            $material = Materials::find($request->get('material_id'));
        }

        return Inertia::render(
            'Invoices/InvoiceAdd',
            [
                'factories' => $factories,
                'materials' => $materials,
                'colours' => $colours,
                'suppliers' => $suppliers,
                'units' => $units,
                'currencies' => $currencies,
                'material' => $material,
                'materialPurchaseOrder' => $materialPurchaseOrder
            ]
        );
    }

    public function store(CreateInvoices $createInvoices, Request $request)
    {
        $invoiceDto = new Invoice();
        $invoiceDto->number = $request->input('number');
        $invoiceDto->poNumber = $request->input('po_number');
        $invoiceDto->invoicedDate = $request->input('invoiced_date');
        $invoiceDto->factory = Factory::find($request->input('factory_id'));
        $invoiceDto->supplier = Supplier::find($request->input('supplier_id'));

        $invoiceDto->items = collect($request->input('items'))->map(function ($inputItem, $index) {
            $item = new InvoiceItem();
            $item->material = Materials::find($inputItem['material_name_id']);
            $item->colour = Colour::find($inputItem['material_colour_id']);
            $item->unit_price = $inputItem['unit_price'];
            $item->quantity = $inputItem['quantity'];
            $item->sub_total = $inputItem['sub_total'];
            $item->currency = $inputItem['currency'];

            return $item;
        })->toArray();

        $createInvoices->execute($invoiceDto);

        return Redirect::route('inventory.index');
    }

    public function show(MaterialInvoice $invoice)
    {
        $invoice->loadMissing(['items.variation.material', 'items.variation.colour', 'sawingFactory', 'supplier']);
        return Inertia::render(
            'Invoices/InvoiceShow',
            [
                'invoice' => [$invoice],
            ]
        );
    }
}

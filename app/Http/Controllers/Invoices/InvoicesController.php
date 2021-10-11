<?php

namespace App\Http\Controllers\Invoices;

use App\Domains\Invoices\Actions\CreateInvoices;
use App\Domains\Invoices\Dtos\Invoice;
use App\Domains\Invoices\Dtos\InvoiceItem;
use App\Http\Controllers\Controller;
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
            'Invoices/InvoiceAdd',
            [
                'factories' => $factories,
                'materials' => $materials,
                'colours' => $colours,
                'suppliers' => $suppliers,
                'units' => $units
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
            $item->price = $inputItem['price'];
            $item->quantity = $inputItem['quantity'];

            return $item;
        })->toArray();

        $createInvoices->execute($invoiceDto);

        return Redirect::route('inventory.index');
    }

    public function show(MaterialInvoice $invoice)
    {
        $invoice->loadMissing(['items.variation.material','items.variation.colour','sawingFactory','supplier']);
        return Inertia::render(
            'Invoices/InvoiceShow',
            [
                'invoice' => [$invoice],
            ]
        );
    }
}

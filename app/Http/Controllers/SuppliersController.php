<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Colour;
use App\Models\Country;
use App\Models\Materials;
use App\Models\MaterialSupplier;
use App\Models\Supplier;
use App\Models\SupplierContact;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class SuppliersController extends Controller
{
    public function index()
    {
        return Inertia::render(
            'Suppliers/SuppliersIndex',
            [
                'suppliers' => Supplier::query()->with(['contacts', 'addresses'])
                    ->paginate(15)
                    ->withQueryString(),
            ]
        );
    }

    public function create()
    {
        return Inertia::render('Suppliers/SupplierAdd',
            [
                'crudAction' => 'create'
            ]
        );
    }

    public function store(StoreSupplierRequest $request)
    {
        try {
            $validated = $request->validated();

            $supplier = [
                'name' => $validated['name'] ?? '',
                'email' => $validated['email'] ?? '',
                'description' => $validated['description'] ?? '',
                'currency' => Supplier::NZD
            ];

            $savedSupplier = Supplier::query()->create($supplier);

            return Redirect::route('suppliers.edit',
                [$savedSupplier->id]
            )
                ->with(['message' => 'successfully created']);

        } catch (\Exception $ex) {
            return back()->withInput()->with(['message' => $ex->getMessage()]);
        }
    }

    public function edit(Supplier $supplier)
    {
        $contacts = SupplierContact::query()
            ->where('supplier_id', $supplier->id)
            ->whereNull('deleted_at')
            ->get();

        $savedSupplier = Supplier::query()
            ->with(['addresses.address.country', 'contacts'])
            ->find($supplier->id);

        $materialSuppliers = MaterialSupplier::query()
            ->with(['variation', 'variation.colour', 'variation.material'])
            ->where('supplier_id', $supplier->id)
            ->get();

        $countries = Country::all();
        $materials = Materials::all();
        $colours = Colour::all();

        return Inertia::render('Suppliers/SupplierUpdate',
            [
                'crudAction' => 'edit',
                'contacts' => $contacts,
                'initSupplier' => $savedSupplier,
                'countries' => $countries,
                'materials' => $materials,
                'colours' => $colours,
                'materialSuppliers' => $materialSuppliers
            ]
        );
    }

    public function update(Supplier $supplier, UpdateSupplierRequest $request)
    {
        try {
            $validated = $request->validated();

            $supplierDetails = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'description' => $validated['description'],
            ];

            $supplier->fill($supplierDetails);
            $supplier->save();

            return Redirect::route('suppliers.edit', [$supplier->id])
                ->with(['message' => 'successfully updated']);

        } catch (\Exception $ex) {
            return back()->withInput()->with(['message' => $ex->getMessage()]);
        }
    }

    public function delete(Supplier $supplier)
    {
        return Redirect::route('suppliers.index')
            ->with(['message' => 'delete not allowed']);
    }
}

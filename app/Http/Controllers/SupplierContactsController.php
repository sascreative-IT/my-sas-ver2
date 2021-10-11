<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierContactRequest;
use App\Http\Requests\UpdateSupplierContactRequest;
use App\Models\SupplierContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SupplierContactsController extends Controller
{
    public function store(StoreSupplierContactRequest $request)
    {
        SupplierContact::query()->create($request->all());

        return Redirect::route('suppliers.edit', [$request->input('supplier_id')])->with(['message' => 'successfully saved']);
    }

    public function update(SupplierContact $supplierContact, UpdateSupplierContactRequest $request)
    {
        $validated = $request->validated();
        $supplierContact->fill($validated);
        $supplierContact->save();

        return Redirect::route('suppliers.edit', ['supplier' =>  $supplierContact->supplier_id])->with(['message' => 'successfully updated']);
    }

    public function delete(SupplierContact $supplierContact)
    {
        $supplierContact->delete();

        return Redirect::route('suppliers.edit', ['supplier' =>  $supplierContact->supplier_id])->with(['message' => 'successfully deleted']);
    }
}

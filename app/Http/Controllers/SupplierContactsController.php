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
        try {
            SupplierContact::query()->create($request->all());

            return Redirect::route('suppliers.edit',
                [$request->input('supplier_id')])
                ->with(['message' => 'successfully saved']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function update(SupplierContact $supplierContact, UpdateSupplierContactRequest $request)
    {
        try {
            $validated = $request->validated();
            $supplierContact->fill($validated);
            $supplierContact->save();

            return Redirect::route('suppliers.edit',
                ['supplier' => $supplierContact->supplier_id])->with(['message' => 'successfully updated']);

        } catch (\Exception $ex) {
            return back()->withInput()->with(['message' => $ex->getMessage(), 'type' => 'error']);
        }
    }

    public function delete(SupplierContact $supplierContact)
    {
        try {
            $supplierContact->delete();

            return Redirect::route('suppliers.edit',
                ['supplier' => $supplierContact->supplier_id])
                ->with(['message' => 'successfully deleted']);

        } catch (\Exception $ex) {
            return back()->withInput()->with(['message' => $ex->getMessage(), 'type' => 'error']);
        }
    }
}

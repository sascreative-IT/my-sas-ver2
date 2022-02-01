<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierAddressRequest;
use App\Http\Requests\UpdateSupplierAddressRequest;
use App\Models\Address;
use App\Models\Supplier;
use App\Models\SupplierAddress;
use Illuminate\Support\Facades\Redirect;

class SupplierAddressController extends Controller
{
    public function store(StoreSupplierAddressRequest $request)
    {
        try {
            $validated = $request->validated();
            $address = [
                'line_1' => $validated['line_1'],
                'line_2' => $validated['line_2'],
                'line_3' => $validated['line_3'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'country_id' => $validated['country_id'],
            ];
            $savedAddress = Address::query()->create($address);
            $AddressOfSupplier = ['address_id' => $savedAddress->id];
            $savedSupplierAddress = new SupplierAddress($AddressOfSupplier);
            $supplier = Supplier::query()->find($validated['supplier_id']);
            $supplier->addresses()->save($savedSupplierAddress);

            return Redirect::route('suppliers.edit', [$supplier->id])
                ->with(['message' => 'successfully saved']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function update(Address $address, UpdateSupplierAddressRequest $request)
    {
        try {
            $validated = $request->validated();
            $supplier = Supplier::query()->find($validated['supplier_id']);

            $editedAddress = [
                'line_1' => $validated['line_1'],
                'line_2' => $validated['line_2'],
                'line_3' => $validated['line_3'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'country_id' => $validated['country_id'],
            ];

            $updatedAddress = $address->fill($editedAddress);
            $updatedAddress->save();

            return Redirect::route('suppliers.edit', [$supplier->id])
                ->with(['message' => 'successfully updated']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function delete(Address $address)
    {
        try {
            $supplierId = $address->supplierAddresses->first()->supplier_id;
            $address = Address::query()->findOrFail($address->id);
            $address->delete();

            return Redirect::route('suppliers.edit', [$supplierId])
                ->with(['message' => 'successfully deleted']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaterialSupplierRequest;
use App\Http\Requests\UpdateMaterialSupplierRequest;
use App\Models\MaterialSupplier;
use App\Models\MaterialVariation;
use App\Models\Supplier;
use Illuminate\Support\Facades\Redirect;

class MaterialSupplierController extends Controller
{
    public function store(StoreMaterialSupplierRequest $request)
    {
        try {
            $validated = $request->validated();
            $supplier = Supplier::query()->find($validated['supplier_id']);

            $variation = MaterialVariation::query()
                ->where('material_id', $validated['material']['id'])
                ->where('colour_id', $validated['color']['id'])
                ->first();

            if (!$variation) {
                $variation = MaterialVariation::query()->create([
                    'material_id' => $validated['material']['id'],
                    'colour_id' => $validated['color']['id'],
                ]);
            }


            $materialSupplier = [
                'variation_id' => $variation->id
            ];

            $savedSupplierAddress = new MaterialSupplier($materialSupplier);

            $supplier
                ->materialSuppliers()
                ->save($savedSupplierAddress);

            return Redirect::route('suppliers.edit', [$supplier->id])
                ->with(['message' => 'successfully saved']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function update(MaterialSupplier $materialSupplier, UpdateMaterialSupplierRequest $request)
    {
        try {
            $validated = $request->validated();
            $supplier = Supplier::query()->find($validated['supplier_id']);

            $variation = MaterialVariation::query()
                ->where('material_id', $validated['material']['id'])
                ->where('colour_id', $validated['color']['id'])
                ->first();

            if (!$variation) {
                $variation = MaterialVariation::query()->create([
                    'material_id' => $validated['material']['id'],
                    'colour_id' => $validated['color']['id'],
                ]);
            }

            $materialSupplierData = [
                'variation_id' => $variation->id
            ];

            $updatedMaterialSupplier = $materialSupplier->fill($materialSupplierData);
            $updatedMaterialSupplier->save();

            return Redirect::route('suppliers.edit', [$supplier->id])
                ->with(['message' => 'successfully updated']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}

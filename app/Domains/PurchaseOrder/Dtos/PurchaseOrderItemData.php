<?php


namespace App\Domains\PurchaseOrder\Dtos;

use App\Models\MaterialVariation;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;

class PurchaseOrderItemData extends DataTransferObject
{
    public MaterialVariation $material_variation;
    public float $quantity;
    public string $unit;
    public float $price;
    public string $currency;

    public static function fromRequest(FormRequest $request): PurchaseOrderItemData
    {
        return new self([
            'material_variation' => MaterialVariation::findOrFail($request->input('material_variation_id')),
            'quantity' => $request->input('quantity'),
            'unit' => $request->input('unit'),
            'price' => $request->input('price'),
            'currency' => $request->input('currency') ?: config("mysas.default_currency")
        ]);
    }
}

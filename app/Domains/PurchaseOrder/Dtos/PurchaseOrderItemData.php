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
    public float $unitPrice;
    public float $subTotal;
    public string $currency;

    public static function fromRequest(array $item): PurchaseOrderItemData
    {
        return new self([
            'material_variation' => MaterialVariation::findOrFail($item['material_variation_id']),
            'quantity' => $item['quantity'],
            'unit' => $item['unit'],
            'unitPrice' => $item['unit_price'],
            'subTotal' => $item['sub_total'],
            'currency' => $item['currency'] ?: config("mysas.default_currency")
        ]);
    }
}

<?php

namespace App\Http\Requests\PurchaseOrder;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseOrderItemRequest extends FormRequest
{

    public function authorize(): bool
    {
        return false;
    }


    public function rules(): array
    {
        return [
            'material_variation_id' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'price' => 'required',
            'currency' => 'required',
        ];
    }
}

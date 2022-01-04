<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterialSupplierRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'supplier_id' => 'required',
            'color' => 'required',
            'material' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'supplier_id.required' => 'Supplier field is required!',
            'color.required' => 'Color field is required!',
            'material.required' => 'Material field is required!'
        ];
    }
}

<?php

namespace App\Http\Requests\Styles;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewCustomizedStyleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|unique:styles,code',
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'production_time' => 'required|integer',
            'customer' => 'required',
            'customer.id' => 'exists:customers,id',
            'item_type' => 'required',
            'item_type.*.id' => 'exists:item_types,id',
            'description' => 'nullable',
            'belongs_to' => 'required',
            'status' => 'required',
            'sizes' => 'required|array',
            'sizes.*.id' => 'exists:sizes,id',
            'factories' => 'required',
            'factories.*.id' => 'exists:factories,id',
            'categories' => 'required|array',
            'categories.*.ids' => 'exists:categories,id',
            'panels' => 'required|array',
        ];
    }
}

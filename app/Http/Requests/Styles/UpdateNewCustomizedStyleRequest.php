<?php

namespace App\Http\Requests\Styles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewCustomizedStyleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required',
            'name' => 'required',
            'categories' => 'required|array',
            'categories.*.ids' => 'exists:categories,id',
            'item_type' => 'required',
            'item_type.*.id' => 'exists:item_types,id',
            'customer' => 'nullable',
            'customer.id' => 'exists:customers,id',
            'production_time' => 'required|integer',
            'sizes' => 'required|array',
            'sizes.*.id' => 'exists:sizes,id',
            'factories' => 'required',
            'factories.*.id' => 'exists:factories,id',
            'panels' => 'required|array',
        ];
    }

}

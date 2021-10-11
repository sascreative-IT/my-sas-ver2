<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email',
            'description' => 'string|max:255',
            'currency' => 'string|max:3'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required!',
            'email.required' => 'Email field is required!',
            'description.required' => 'string|max:255',
            'currency.required' => 'Currency field is required!'
        ];
    }
}

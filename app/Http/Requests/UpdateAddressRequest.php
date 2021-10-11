<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'line_1' => 'required|string|min:2|max:255',
            'line_2' => 'string|min:2|max:255',
            'line_3' => 'string|min:2|max:255',
            'city' => 'required|string|min:2|max:50',
            'postal_code' => 'required|string|min:2|max:20',
            'country_id' => 'required|integer',
            'customer_id' => 'required|integer',
            'type' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'line_1.required' => 'Name field is required!',
            'city.required' => 'City field is required!',
            'postal_code.required' => 'Postal code field is required!',
            'country_id.required' => 'Country field is required!',
            'customer_id.required' => 'Customer is required!',
            'type' => 'Address type is required!',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreColourRequest extends FormRequest
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
            'type' => 'required|string',
            'is_active' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required!',
            'type.required' => 'type field is required!',
            'is_active.required' => 'Active field is required!',
        ];
    }
}

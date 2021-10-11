<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOutletRequest extends FormRequest
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
            'country_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required!',
            'country_id.required' => 'Country field is required!',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSizesRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            '*.name' => 'bail|required|unique:sizes,name',
        ];
    }

    public function messages()
    {
        return [
            '*.name.required' => 'Size field is required!',
            '*.name.unique' => 'Size already exists!',
        ];
    }
}

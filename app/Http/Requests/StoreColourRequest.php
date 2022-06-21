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
        $request = $this;
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                Rule::unique('colours')
                    ->where('type', $request->get('type'))
                    ->where(function ($query) use ($request){
                        return $query->where('name', $request->get('name'));
                    })
            ],
            'type' => 'required|string',
            'is_active' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required!',
            'name.unique' => 'Colour Already Exist',
            'type.required' => 'type field is required!',
            'is_active.required' => 'Active field is required!',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'cs_agent_id' => 'required|integer',
            'sales_agent_id' => 'required|integer',
            'logo_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required!',
            'email.required' => 'Email field is required!',
            'cs_agent_id.required' => 'Customer Service agent field is required!',
            'sales_agent_id.required' => 'Sales agent field is required!',
            'logo_id.required' => 'A logo is required!'
        ];
    }
}

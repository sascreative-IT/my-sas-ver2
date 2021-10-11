<?php

namespace App\Http\Requests;


use App\Models\CustomerContact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCustomerContactRequest extends FormRequest
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
            'first_name' => 'required|string|min:2|max:100',
            'last_name' => 'required|string|min:2|max:100',
            'email' => 'required|email',
            'contact_no' => 'required|string|min:10|max:15',
            'designation' => 'string|max:100',
            'type' => ['required', Rule::in(CustomerContact::$types)],
            'customer_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First Name field is required!',
            'last_name.required' => 'Last Name field is required!',
            'email.required' => 'Email field is required!',
            'contact_no.required' => 'Contact number field is required!',
            'type.required' => 'Contact type field is required!',
            'customer_id.required' => 'The customer is required!'
        ];
    }
}

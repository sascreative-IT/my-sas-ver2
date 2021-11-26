<?php


namespace App\Http\Requests\StockOut;


use Illuminate\Foundation\Http\FormRequest;

class StockOutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_public_id' => 'required',
            'factory_id' => 'required',
            'customer_id' => 'required',
        ];
    }
}

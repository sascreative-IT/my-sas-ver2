<?php

namespace App\Http\Requests\Styles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomizedStyleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customized_panels' => 'sometimes|array',
            'customized_panels.*.colourId' => 'integer',
            'customized_panels.*.fabricId' => 'integer',
            'customized_panels.*.id' => 'integer'
        ];
    }
}

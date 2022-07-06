<?php
declare(strict_types=1);

namespace App\Http\Requests\Styles;

use App\Domains\Styles\Dto\Style;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class StyleStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|unique:styles,code',
            'name' => 'required',
            'categories' => ['required', 'array'],
            'categories.*.ids' => 'exists:categories,id',
            'item_type' => 'required',
            'item_type.*.id' => 'exists:item_types,id',
            'customer' => 'nullable',
            'customer.id' => 'exists:customers,id',
            'parent_style' => 'nullable',
            'parent_style.*.id' => 'exists:styles,code',
            'production_time' => 'required|integer',
            'sizes' => 'required|array',
            'sizes.*.id' => 'exists:sizes,id',
            'factories' => 'required',
            'factories.*.id' => 'exists:factories,id',
//            'panels'
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Please enter a style code',
            'code.unique' => 'This style code is already been used. Please use another one',
            'name.unique' => 'Please enter a style name',
            'category_ids.required' => 'Please select a category',
            'category_ids.exists' => 'Trying to select a category that doesnt exists',
            'item_type_id.required' => 'Please select a type',
            'customer_id.exists' => 'Trying to select a customer that doesnt exists',
            'extending_style_id.exists' => 'Trying to select a extending style that doesnt exists',
            'production_time.required' => 'Please enter production time',
            'production_time.integer' => 'Production time must be enter as minutes',
            'sizes.required' => 'Please select sizes',
            'sizes.exists' => 'Trying to select a size that doesnt exists',
            'factories.required' => 'Please select a factory',
        ];
    }

    public function toDto(): Style
    {
        return new Style(array_merge($this->all(), ['status' => 'active']));
    }

    protected function prepareForValidation()
    {
        if ($this->has('code')) {
            $this->merge(['code'=> Str::upper($this->code)]);
        }

        if ($this->has('customized_panels')) {
            if (empty($this->customized_panels)) {
                throw ValidationException::withMessages(['panel' => 'Panels cannot be empty. Please add panels']);
            } else {
                foreach ($this->customized_panels as $panel) {
                    if ($panel['fabricId'] == null || $panel['colourId'] == null) {
                        throw ValidationException::withMessages(['panel' => 'Panel fields cannot be empty. Please fill in all fields']);
                    }
                }
            }
        }
    }
}

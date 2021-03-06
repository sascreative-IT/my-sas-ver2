<?php
declare(strict_types=1);

namespace App\Http\Requests\Styles;

use App\Domains\Styles\Dto\CustomizedStyle;
use Illuminate\Foundation\Http\FormRequest;

class StyleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required',
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
            'code.unique' => 'This style code is already been used',
            'name.unique' => 'Please enter a style name',
            'category_ids.required' => 'Please select a category',
            'category_ids.exists' => 'Trying to select a category that doesnt exists',
            'customer_id.exists' => 'Trying to select a customer that doesnt exists',
            'parent_style.exists' => 'Trying to select a extending style that doesnt exists',
            'production_time.required' => 'Please enter production time',
            'production_time.integer' => 'Production time must be enter as minutes',
            'sizes.required' => 'Please select sizes',
            'sizes.exists' => 'Trying to select a size that doesnt exists',
            'factories.required' => 'Please select a factory',
        ];
    }

    public function toDto(): CustomizedStyle
    {
        return new CustomizedStyle(array_merge($this->all(), ['status' => 'draft']));
    }

    protected function prepareForValidation()
    {
        if ($this->has('code'))
            $this->merge(['code'=> strtolower($this->code)]);
    }
}

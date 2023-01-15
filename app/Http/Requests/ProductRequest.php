<?php

namespace App\Http\Requests;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => 'required|max:255',
            'price'       => 'required|numeric',
            'description' => 'nullable|max:5000',
            'subcategory_id'       => 'required|integer|exists:subcategories,id',
        ];
    }
}

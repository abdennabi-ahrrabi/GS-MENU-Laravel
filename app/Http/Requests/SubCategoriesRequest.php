<?php

namespace App\Http\Requests;

class SubCategoriesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'Parent_Category_id' => 'required|integer|exists:categories,id' 
        ];
    }
}
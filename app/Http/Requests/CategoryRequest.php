<?php

namespace App\Http\Requests;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'restaurant_id' => 'required|integer|exists:restaurants,id' 
        ];
    }
}
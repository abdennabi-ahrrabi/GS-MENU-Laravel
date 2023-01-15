<?php

namespace App\Http\Requests;

class RestaurantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'location' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'description' => 'required|string',
            'user_id' => 'required|integer|exists:users,id' 
        ];
    }
}

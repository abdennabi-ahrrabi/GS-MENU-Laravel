<?php

namespace App\Repositories;

use App\Interfaces\ActionsInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Type\NullType;

class UserRepository{
    
    public function register(array $data): User
    {
        $data = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ];

        return User::create($data);
    }
}
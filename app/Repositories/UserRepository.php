<?php

namespace App\Repositories;

use App\Interfaces\ActionsInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Type\NullType;

class UserRepository implements ActionsInterface{
    
    public function getAll(int $perPage = 10): Paginator
    {
        return  User::paginate($perPage);
    }

    public function getByid(int $id): User
    {
        return User::find($id);   
    }

    public function create(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'telephone' => 'required|string', // Add this line
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Create a new user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'telephone' => $request->telephone, // Add this line
        ]);

        return $user;
    }

    public function update(Request $request, $id): User
    {
        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->password = $request->password;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->save();

        return $user;
    }

    public function delete($id): Paginator
    {
        User::destroy($id);
        return  User::paginate();
    }
}
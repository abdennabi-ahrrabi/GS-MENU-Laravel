<?php

namespace App\Repositories;

use App\Interfaces\ActionsInterface;
use App\Models\Admin;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminRepository implements ActionsInterface{
    
    public function getAll(int $perPage = 10): Paginator
    {
        return  Admin::paginate($perPage);
    }

    public function getByid(int $id): Admin
    {
        return Admin::find($id);   
    }

    public function create(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:admins',
            'username' => 'required|string|unique:admins',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Create a new admin
        $admin = Admin::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return $admin;
    }
    

    public function update(Request $request, $id)
    {

       
        $admin = Admin::find($id);

        // Create a new admin
        $admin->update([
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return $admin;
    }

    public function delete($id): Paginator
    {
        
        Admin::destroy($id);
        return  Admin::paginate();
    }
}
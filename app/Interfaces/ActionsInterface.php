<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

interface ActionsInterface{
    
    public function getAll();
    
    public function getByid(int $id);

    public function create(Request $request);

    public function update(Request $request, $id);

    public function delete($id);

}
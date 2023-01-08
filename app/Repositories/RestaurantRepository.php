<?php

namespace App\Repositories;

use App\Interfaces\ActionsInterface;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantRepository implements ActionsInterface
{
    public function getAll()
    {
        return Restaurant::with('user')->get();
    }

    public function getById(int $id): Restaurant
    {
        return Restaurant::with('user')->find($id);
    }

    public function create(Request $request): Restaurant
    {
        return Restaurant::create($request->all());
    }

    public function update(Request $request,$id): Restaurant
    {
        $restaurant = Restaurant::find($id);
        $restaurant->update($request->all());

        return $restaurant;
    }

    public function delete($id)
    {
        Restaurant::find($id)->delete();
        return Restaurant::all();;
    }
}
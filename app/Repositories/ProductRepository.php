<?php

namespace App\Repositories;

use App\Interfaces\ActionsInterface;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductRepository implements ActionsInterface
{
    public function getAll()
    {
        return Product::with('restaurant')->get();
    }

    public function getById(int $id)
    {
        return Product::find($id);
    }

    public function create(Request $request)
    {
        return Product::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());

        return $product;
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        return Product::all();;
    }
}

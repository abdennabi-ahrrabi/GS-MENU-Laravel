<?php

namespace App\Repositories;

use App\Interfaces\ActionsInterface;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryRepository implements ActionsInterface
{
    public function getAll()
    {
        return Category::with('product')->get();
    }

    public function getById(int $id): Category
    {
        return Category::with('product')->find($id);
    }

    public function create(Request $request): Category
    {
        return Category::create($request->all());
    }

    public function update(Request $request, $id): Category
    {
        $category = Category::find($id);
        $category->update($request->all());

        return $category;
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        return Category::all();;
    }
}

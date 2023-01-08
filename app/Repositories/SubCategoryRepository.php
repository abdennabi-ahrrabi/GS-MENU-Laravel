<?php

namespace App\Repositories;

use App\Interfaces\ActionsInterface;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryRepository implements ActionsInterface
{
    public function getAll()
    {
        return SubCategory::with('category')->get();
    }

    public function getById(int $id): SubCategory
    {
        return SubCategory::with('category')->find($id);
    }

    public function create(Request $request): SubCategory
    {
        return SubCategory::create($request->all());
    }

    public function update(Request $request, $id): SubCategory
    {
        $subcategory = SubCategory::find($id);
        $subcategory->update($request->all());

        return $subcategory;
    }

    public function delete($id)
    {
        SubCategory::find($id)->delete();
        return SubCategory::all();;
    }
}

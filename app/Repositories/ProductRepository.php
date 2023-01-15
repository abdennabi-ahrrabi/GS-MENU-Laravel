<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class ProductRepository implements CrudInterface
{
    /**
     * Authenticated User Instance.
     *
     * @var User
     */
    public User | null $user;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->user = Auth::guard()->user();
    }

    /**
     * Get All Products.
     *
     * @return collections Array of Product Collection
     */
    public function getAll(): Paginator
    {
        return Product::whereIn('subcategory_id', SubCategory::whereIn('Parent_Category_id', $this->user->categories->pluck('id'))->pluck('id'))
            ->orderBy('id', 'desc')
            ->with('subcategory')
            ->paginate(10);
    }

    /**
     * Get Paginated Product Data.
     *
     * @param int $pageNo
     * @return collections Array of Product Collection
     */
    public function getPaginatedData($perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 12;
        return Product::orderBy('id', 'desc')
        ->with('subcategory')
        ->paginate($perPage);
    }

    /**
     * Get Searchable Product Data with Pagination.
     *
     * @param int $pageNo
     * @return collections Array of Product Collection
     */
    public function search($keyword, $perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 10;

        return Product::where('name', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%')
            ->orWhere('price', 'like', '%' . $keyword . '%')
            ->orderBy('id', 'desc')
            ->with('subcategory')
            ->paginate($perPage);
    }

    /**
     * Create New Product.
     *
     * @param array $data
     * @return object Product Object
     */
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * Delete Product.
     *
     * @param int $id
     * @return boolean true if deleted otherwise false
     */
    public function delete(int $id): bool
    {
        $product = Product::find($id);
        if (empty($product)) {
            return false;
        }
        $product->delete($product);
        return true;
    }

    /**
     * Get Product Detail By ID.
     *
     * @param int $id
     * @return void
     */
    public function getByID(int $id): Product|null
    {
        return Product::with('subcategory')->find($id);
    }

    /**
     * Update Product By ID.
     *
     * @param int $id
     * @param array $data
     * @return object Updated Product Object
     */
    public function update(int $id, array $data): Product|null
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return null;
        }

        // If everything is OK, then update.
        $product->update($data);

        // Finally return the updated product.
        return $this->getByID($product->id);
    }
}

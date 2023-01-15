<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class CategoryRepository implements CrudInterface
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
     * Get All Categorys.
     *
     * @return collections Array of Category Collection
     */
    public function getAll(): Paginator
    {
        return Category::whereIn('restaurant_id', $this->user->restaurants->pluck('id'))
        ->orderBy('id', 'desc')
        ->with('restaurants')
        ->paginate(10);
    }

    /**
     * Get Paginated Category Data.
     *
     * @param int $pageNo
     * @return collections Array of Category Collection
     */
    public function getPaginatedData($perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 12;
        return Category::orderBy('id', 'desc')
            ->with('restaurants')
            ->paginate($perPage);
    }

    /**
     * Get Searchable Category Data with Pagination.
     *
     * @param int $pageNo
     * @return collections Array of Category Collection
     */
    public function search($keyword, $perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 10;

        return Category::whereIn('restaurant_id', $this->user->restaurants->pluck('id'))->where('name', 'like', '%' . $keyword . '%')
        ->orderBy('id', 'desc')
        ->with('restaurants')
        ->paginate(10);
    }

    /**
     * Create New Category.
     *
     * @param array $data
     * @return object Category Object
     */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Delete Category.
     *
     * @param int $id
     * @return boolean true if deleted otherwise false
     */
    public function delete(int $id): bool
    {
        $Category = Category::find($id);
        if (empty($Category)) {
            return false;
        }
        $Category->delete($Category);
        return true;
    }

    /**
     * Get Category Detail By ID.
     *
     * @param int $id
     * @return void
     */
    public function getByID(int $id): Category|null
    {
        return Category::with('restaurants')->find($id);
    }

    /**
     * Update Category By ID.
     *
     * @param int $id
     * @param array $data
     * @return object Updated Category Object
     */
    public function update(int $id, array $data): Category|null
    {
        $Category = Category::find($id);
        

        if (is_null($Category)) {
            return null;
        }

        // If everything is OK, then update.
        $Category->update($data);

        // Finally return the updated Category.
        return $this->getByID($Category->id);
    }
}
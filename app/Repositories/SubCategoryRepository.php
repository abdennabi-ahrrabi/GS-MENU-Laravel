<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class SubCategoryRepository implements CrudInterface
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
     * Get All SubCategories.
     *
     * @return collections Array of SubCategory Collection
     */
    public function getAll(): Paginator
    {
        return SubCategory::whereIn('Parent_Category_id', $this->user->categories->pluck('id'))
            ->orderBy('id', 'desc')
            ->with('category')
            ->paginate(10);
    }

    /**
     * Get Paginated SubCategory Data.
     *
     * @param int $pageNo
     * @return collections Array of SubCategory Collection
     */
    public function getPaginatedData($perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 12;
        return SubCategory::orderBy('id', 'desc')
            ->with('category')
            ->paginate($perPage);
    }

    /**
     * Get Searchable SubCategory Data with Pagination.
     *
     * @param int $pageNo
     * @return collections Array of SubCategory Collection
     */
    public function search($keyword, $perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 10;

        return SubCategory::where('name', 'like', '%' . $keyword . '%')
            ->orderBy('id', 'desc')
            ->with('category')
            ->paginate($perPage);
    }

    /**
     * Create New SubCategory.
     *
     * @param array $data
     * @return object SubCategory Object
     */
    public function create(array $data): SubCategory
    {
        return SubCategory::create($data);
    }

    /**
     * Delete SubCategory.
     *
     * @param int $id
     * @return boolean true if deleted otherwise false
     */
    public function delete(int $id): bool
    {
        $SubCategory = SubCategory::find($id);
        if (empty($SubCategory)) {
            return false;
        }
        $SubCategory->delete($SubCategory);
        return true;
    }

    /**
     * Get SubCategory Detail By ID.
     *
     * @param int $id
     * @return void
     */
    public function getByID(int $id): SubCategory|null
    {
        return SubCategory::with('category')->find($id);
    }

    /**
     * Update SubCategory By ID.
     *
     * @param int $id
     * @param array $data
     * @return object Updated SubCategory Object
     */
    public function update(int $id, array $data): SubCategory|null
    {
        $SubCategory = SubCategory::find($id);
        

        if (is_null($SubCategory)) {
            return null;
        }

        // If everything is OK, then update.
        $SubCategory->update($data);

        // Finally return the updated SubCategory.
        return $this->getByID($SubCategory->id);
    }
}
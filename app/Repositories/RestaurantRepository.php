<?php

namespace App\Repositories;


use App\Interfaces\CrudInterface;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class RestaurantRepository implements CrudInterface
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
        return $this->user->restaurants()
            ->orderBy('id', 'desc')
            ->with('user')
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
        return Restaurant::orderBy('id', 'desc')
            ->with('user')
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

        return Restaurant::where('name', 'like', '%' . $keyword . '%')
            ->orWhere('location', 'like', '%' . $keyword . '%')
            ->orWhere('address', 'like', '%' . $keyword . '%')
            ->orderBy('id', 'desc')
            ->with('user')
            ->paginate($perPage);
    }

    /**
     * Create New Restaurant.
     *
     * @param array $data
     * @return object Restaurant Object
     */
    public function create(array $data): Restaurant
    {
        return Restaurant::create($data);
    }

    /**
     * Delete Restaurant.
     *
     * @param int $id
     * @return boolean true if deleted otherwise false
     */
    public function delete(int $id): bool
    {
        $Restaurant = Restaurant::find($id);
        if (empty($Restaurant)) {
            return false;
        }
        $Restaurant->delete($Restaurant);
        return true;
    }

    /**
     * Get Restaurant Detail By ID.
     *
     * @param int $id
     * @return void
     */
    public function getByID(int $id): Restaurant|null
    {
        return Restaurant::with('user')->find($id);
    }

    /**
     * Update Restaurant By ID.
     *
     * @param int $id
     * @param array $data
     * @return object Updated Restaurant Object
     */
    public function update(int $id, array $data): Restaurant|null
    {
        $Restaurant = Restaurant::find($id);
        

        if (is_null($Restaurant)) {
            return null;
        }

        // If everything is OK, then update.
        $Restaurant->update($data);

        // Finally return the updated Restaurant.
        return $this->getByID($Restaurant->id);
    }
}
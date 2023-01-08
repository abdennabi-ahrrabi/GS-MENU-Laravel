<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Repositories\RestaurantRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    use ResponseTrait;
    protected $repository;

    public function __construct(RestaurantRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @OA\Get(
     *     path="/api/restaurants",
     *     tags={"Restaurants"},
     *     summary="List of Restaurants",
     *     description="Multiple status values can be provided with comma separated string",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
     */
    public function index()
    {
        try{
            $repository = new RestaurantRepository();
            return $this->responseSuccess($this->repository->getAll());
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }

        /**
     * Create a Restaurant
     * @OA\Post (
     *     path="/api/restaurants/store",
     *     tags={"Restaurants"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          description="Name of the restaurant"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string",
     *                          description="Description of the restaurant"
     *                      ),
     *                      @OA\Property(
     *                          property="website",
     *                          type="string",
     *                          description="Website of the restaurant"
     *                      ),
     *                      @OA\Property(
     *                          property="telephone",
     *                          type="string",
     *                          description="Telephone number of the restaurant"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string",
     *                          description="Email of the restaurant"
     *                      ),
     *                      @OA\Property(
     *                          property="address1",
     *                          type="string",
     *                          description="First line of the restaurant's address"
     *                      ),
     *                      @OA\Property(
     *                          property="address2",
     *                          type="string",
     *                          description="Second line of the restaurant's address"
     *                      ),
     *                      @OA\Property(
     *                          property="ville",
     *                          type="string",
     *                          description="City in which the restaurant is located"
     *                      ),
     *                      @OA\Property(
     *                          property="pay",
     *                          type="string",
     *                          description="Payment methods accepted by the restaurant"
     *                      ),
     *                      @OA\Property(
     *                          property="id_user",
     *                          type="integer",
     *                          description="ID of the user who owns the restaurant"
     *                      )
     *                 ),
     *                 example={
     *                     "name": "My Restaurant",
     *                     "description": "A cozy restaurant with a variety of dishes.",
     *                     "website": "www.myrestaurant.com",
     *                     "telephone": "123-456-7890",
     *                     "email": "info@myrestaurant.com",
     *                     "address1": "123 Main Street",
     *                     "address2": "Suite 100",
     *                     "ville": "My City",
     *                     "pay": "Cash, Credit Card",
     *                     "id_user": 1
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="My Restaurant"),
     *              @OA\Property(property="description", type="string", example="A cozy restaurant with a variety of dishes."),
     *              @OA\Property(property="website", type="string", example="www.myrestaurant.com"),
     *              @OA\Property(property="telephone", type="string", example="123-456-7890"),
     *              @OA\Property(property="email", type="string", example="info@myrestaurant.com"),
     *              @OA\Property(property="address1", type="string", example="123 Main Street"),
     *              @OA\Property(property="address2", type="string", example="Suite 100"),
     *              @OA\Property(property="ville", type="string", example="My City"),
     *              @OA\Property(property="pay", type="string", example="Cash, Credit Card"),
     *              @OA\Property(property="id_user", type="integer", example=1),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *          @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        try{
            $repository = new RestaurantRepository();
            return $this->responseSuccess($this->repository->create($request));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
    /**
     * Get a Restaurant
     * @OA\Get (
     *     path="/api/restaurants/show/{id}",
     *     tags={"Restaurants"},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="My Restaurant"),
     *              @OA\Property(property="description", type="string", example="A cozy restaurant with a variety of dishes."),
     *              @OA\Property(property="website", type="string", example="www.myrestaurant.com"),
     *              @OA\Property(property="telephone", type="string", example="123-456-7890"),
     *              @OA\Property(property="email", type="string", example="info@myrestaurant.com"),
     *              @OA\Property(property="address1", type="string", example="123 Main Street"),
     *              @OA\Property(property="address2", type="string", example="Suite 100"),
     *              @OA\Property(property="ville", type="string", example="My City"),
     *              @OA\Property(property="pay", type="string", example="Cash, Credit Card"),
     *              @OA\Property(property="id_user", type="integer", example=1),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      )
     * )*/

    public function show($id)
    {
        try{
            $repository = new RestaurantRepository();
            return $this->responseSuccess($this->repository->getByid($id));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
    /**
 * Update a Restaurant
 * @OA\Put (
 *     path="/api/restaurants/update/{id}",
 *     tags={"Restaurants"},
 *     @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          )
 *     ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                      type="object",
 *                      @OA\Property(
 *                          property="name",
 *                          type="string",
 *                          description="Name of the restaurant"
 *                      ),
 *                      @OA\Property(
 *                          property="description",
 *                          type="string",
 *                          description="Description of the restaurant"
 *                      ),
 *                      @OA\Property(
 *                          property="website",
 *                          type="string",
 *                          description="Website of the restaurant"
 *                      ),
 *                      @OA\Property(
 *                          property="telephone",
 *                          type="string",
 *                          description="Telephone number of the restaurant"
 *                      ),
 *                      @OA\Property(
 *                          property="email",
 *                          type="string",
 *                          description="Email of the restaurant"
 *                      ),
 *                      @OA\Property(
 *                          property="address1",
 *                          type="string",
 *                          description="First line of the restaurant's address"
 *                      ),
 *                      @OA\Property(
 *                          property="address2",
 *                          type="string",
 *                          description="Second line of the restaurant's address"
 *                      ),
 *                      @OA\Property(
 *                          property="ville",
 *                          type="string",
 *                          description="City where the restaurant is located"
 *                      ),
 *                      @OA\Property(
 *                          property="pay",
 *                          type="string",
 *                          description="Payment methods accepted by the restaurant"
 *                      ),
 *                      @OA\Property(
 *                          property="id_user",
 *                          type="integer",
 *                          description="ID of the user who owns the restaurant"
 *                      )
 *                 ),
 *                 example={
 *                     "name": "Updated Restaurant",
 *                     "description": "An updated, cozy restaurant with a variety of dishes.",
 *                     "website": "www.updatedrestaurant.com",
 *                     "telephone": "123-456-7891",
 *                     "email": "info@updatedrestaurant.com",
 *                     "address1": "124 Main Street",
 *                     "address2": "Suite 101",
 *                     "ville": "Updated City",
 *                     "pay": "Cash, Credit Card, Venmo",
 *                     "id_user": 2
 *                }
 *             )
 *         )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="success",
 *          @OA\JsonContent(
 *              @OA\Property(property="id", type="integer", example=1),
 *              @OA\Property(property="name", type="string", example="Updated Restaurant"),
 *              @OA\Property(property="description", type="string", example="An updated, cozy restaurant with a variety of dishes."),
 *              @OA\Property(property="website", type="string", example="www.updatedrestaurant.com"),
 *              @OA\Property(property="telephone", type="string", example="123-456-7891"),
 *              @OA\Property(property="email", type="string", example="info@updatedrestaurant.com"),
 *              @OA\Property(property="address1", type="string", example="124 Main Street"),
 *              @OA\Property(property="address2", type="string", example="Suite 101"),
 *              @OA\Property(property="ville", type="string", example="Updated City"),
 *              @OA\Property(property="pay", type="string", example="Cash, Credit Card, Venmo"),
 *              @OA\Property(property="id_user", type="integer", example=2),
 *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:30:53.000000Z"),
 *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
 *          )
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="invalid",
 *          @OA\JsonContent(
 *              @OA\Property(property="msg", type="string", example="fail"),
 *          )
 *      )
 * )*/


    public function update(Request $request, $id)
    {
        try{
            $repository = new RestaurantRepository();
            return $this->responseSuccess($this->repository->update($request,$id));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
/**
 * Delete a Restaurant
 * @OA\Delete (
 *     path="/api/restaurants/delete/{id}",
 *     tags={"Restaurants"},
 *     @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Schema(
 *              type="integer"
 *          )
 *     ),
 *      @OA\Response(
 *          response=204,
 *          description="success",
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="invalid",
 *          @OA\JsonContent(
 *              @OA\Property(property="msg", type="string", example="fail"),
 *          )
 *      )
 * )
*/
    public function delete($id)
    {
        try{
            $repository = new RestaurantRepository();
            return $this->responseSuccess($this->repository->delete($id));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
}


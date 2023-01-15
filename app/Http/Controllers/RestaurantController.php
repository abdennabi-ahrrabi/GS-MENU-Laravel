<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequest;
use App\Models\Restaurant;
use App\Repositories\RestaurantRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RestaurantController extends Controller
{
    use ResponseTrait;
    protected $repository;

    public function __construct(RestaurantRepository $repository)
    {
        $this->middleware('auth:api', ['except' => ['indexAll']]);
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
    public function index(): JsonResponse
    {
        try {
            $data = $this->repository->getAll();
            return $this->responseSuccess($data, 'Restaurant List Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/restaurants/all",
     *     tags={"Restaurants"},
     *     summary="All Restaurants - Publicly Accessible",
     *     description="All Restaurants - Publicly Accessible",
     *     @OA\Parameter(name="perPage", description="perPage, eg; 20", example=20, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="All Restaurants - Publicly Accessible" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function indexAll(Request $request): JsonResponse
    {
        try {
            $data = $this->repository->getPaginatedData($request->perPage);
            return $this->responseSuccess($data, 'Restaurant List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/restaurants/search",
     *     tags={"Restaurants"},
     *     summary="All Restaurants - Publicly Accessible",
     *     description="All Restaurants - Publicly Accessible",
     *     @OA\Parameter(name="perPage", description="perPage, eg; 20", example=20, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="search", description="search, eg; Test", example="Test", in="query", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="All Restaurants - Publicly Accessible" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $data = $this->repository->search($request->search, $request->perPage);
            return $this->responseSuccess($data, 'Restaurant List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
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
     *                          property="Location",
     *                          type="string",
     *                          description="Location of the restaurant"
     *                      ),@OA\Property(
     *                          property="Address",
     *                          type="string",
     *                          description="Adress of the restaurant's address"
     *                      ),
     *                      @OA\Property(
     *                          property="Phone Number",
     *                          type="string",
     *                          description="Phone Number of the restaurant"
     *                      ),
     *                      @OA\Property(
     *                          property="Description",
     *                          type="string",
     *                          description="City in which the restaurant is located"
     *                      ),
     *                      @OA\Property(
     *                          property="user_id",
     *                          type="integer",
     *                          description="ID of the user who owns the restaurant"
     *                      )
     *                 ),
     *                 example={
     *                     "name": "KFC",
     *                     "location": "LA",
     *                     "address": "123 ST PARIS",
     *                     "telephone": "123-456-7890",
     *                     "phone_number": "555-555-5555",
     *                     "description": "Fried chicken specialist",
     *                     "user_id": 1
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="KFC"),
     *              @OA\Property(property="Location", type="string", example="LA"),
     *              @OA\Property(property="Address", type="string", example="123 ST PARIS"),
     *              @OA\Property(property="Phone Number", type="string", example="555-555-5555"),
     *              @OA\Property(property="Description", type="string", example="Fried chicken specialist"),
     *              @OA\Property(property="updated_at", type="string", example="2023-01-15T15:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2023-01-15T15:25:53.000000Z"),
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
    public function store(RestaurantRequest $request): JsonResponse
    {
        try {
            $Restaurant = $this->repository->create($request->all());
            return $this->responseSuccess($Restaurant, 'New Restaurant Created Successfully !');
        } catch (\Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
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
     *              @OA\Property(property="name", type="string", example="KFC"),
     *              @OA\Property(property="Location", type="string", example="LA"),
     *              @OA\Property(property="Address", type="string", example="123 ST PARIS"),
     *              @OA\Property(property="Phone Number", type="string", example="555-555-5555"),
     *              @OA\Property(property="Description", type="string", example="Fried chicken specialist"),
     *              @OA\Property(property="updated_at", type="string", example="2023-01-15T15:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2023-01-15T15:25:53.000000Z"),
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

     public function show($id): JsonResponse
     {
         try {
             $data = $this->repository->getByID($id);
             if (is_null($data)) {
                 return $this->responseError(null, 'Restaurant Not Found', Response::HTTP_NOT_FOUND);
             }
 
             return $this->responseSuccess($data, 'Restaurant Details Fetch Successfully !');
         } catch (\Exception $e) {
             return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
         }
     }
    

/**
     * @OA\PUT(
     *     path="/api/restaurants/update/{id}",
     *     tags={"Restaurants"},
     *     summary="Update Restaurant",
     *     description="Update Restaurant",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="KFC"),
     *              @OA\Property(property="Location", type="string", example="LA"),
     *              @OA\Property(property="Address", type="string", example="123 ST PARIS"),
     *              @OA\Property(property="Phone Number", type="string", example="555-555-5555"),
     *              @OA\Property(property="Description", type="string", example="Fried chicken specialist"),
     *              @OA\Property(property="updated_at", type="string", example="2023-01-15T15:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2023-01-15T15:25:53.000000Z"),
     *          ),
     *      ),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200, description="Update Restaurant"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

 public function update(RestaurantRequest $request, $id): JsonResponse
 {
     try {
         $data = $this->repository->update($id, $request->all());
         if (is_null($data))
             return $this->responseError(null, 'Restaurant Not Found', Response::HTTP_NOT_FOUND);

         return $this->responseSuccess($data, 'Restaurant Updated Successfully !');
     } catch (\Exception $e) {
         return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
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
public function destroy($id): JsonResponse
{
    try {
        $Restaurant  =  $this->repository->getByID($id);
        if (empty($Restaurant )) {
            return $this->responseError(null, 'Restaurant Not Found', Response::HTTP_NOT_FOUND);
        }

        $deleted = $this->repository->delete($id);
        if (!$deleted) {
            return $this->responseError(null, 'Failed to delete the restaurant .', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->responseSuccess($Restaurant , 'Restaurant  Deleted Successfully !');
    } catch (\Exception $e) {
        return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
}


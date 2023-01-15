<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    use ResponseTrait;
    protected $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->middleware('auth:api', ['except' => ['indexAll']]);
        $this->repository = $repository;
    }
    
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     tags={"Categories"},
     *     summary="List of Categories",
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
            return $this->responseSuccess($data, 'Categories List Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/categories/all",
     *     tags={"Categories"},
     *     summary="All Categories - Publicly Accessible",
     *     description="All Categories - Publicly Accessible",
     *     @OA\Parameter(name="perPage", description="perPage, eg; 20", example=20, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="All Categories - Publicly Accessible" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function indexAll(Request $request): JsonResponse
    {
        try {
            $data = $this->repository->getPaginatedData($request->perPage);
            return $this->responseSuccess($data, 'Categories List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/categories/search",
     *     tags={"Categories"},
     *     summary="All Categories - Publicly Accessible",
     *     description="All Categories - Publicly Accessible",
     *     @OA\Parameter(name="perPage", description="perPage, eg; 20", example=20, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="search", description="search, eg; Test", example="Test", in="query", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="All Categories - Publicly Accessible" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $data = $this->repository->search($request->search, $request->perPage);
            return $this->responseSuccess($data, 'Categories List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

        /**
     * Create a Category
     * @OA\Post (
     *     path="/api/categories/store",
     *     tags={"Categories"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          description="Name of the category"
     *                      ),
     *                      @OA\Property(
     *                          property="restauant_id",
     *                          type="integer",
     *                          description="ID of the restaurant who have this category"
     *                      )
     *                 ),
     *                 example={
     *                     "name": "Pizza",
     *                     "restaurant_id": 2
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="Pizza"),
     *              @OA\Property(property="restarant_id", type="integer", example=2),
     *              @OA\Property(property="updated_at", type="string", example="2023-01-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2023-01-11T09:25:53.000000Z"),
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
    public function store(CategoryRequest $request): JsonResponse
    {
        try {
            $Category = $this->repository->create($request->all());
            return $this->responseSuccess($Category, 'New Category Created Successfully !');
        } catch (\Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Get a Category
     * @OA\Get (
     *     path="/api/categories/show/{id}",
     *     tags={"Categories"},
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
     *                  @OA\Property(property="name", type="string", example="Category 1"),
     *                  @OA\Property(property="restaurant_id", type="integer", example=1),
     *                  @OA\Property(property="created_at", type="string", example="2023-01-01T22:45:03.000000Z"),
     *                  @OA\Property(property="updated_at", type="string", example="2023-01-01T22:45:03.000000Z"),
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
                 return $this->responseError(null, 'Category Not Found', Response::HTTP_NOT_FOUND);
             }
 
             return $this->responseSuccess($data, 'Category Details Fetch Successfully !');
         } catch (\Exception $e) {
             return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
         }
     }

/**
     * @OA\PUT(
     *     path="/api/categories/update/{id}",
     *     tags={"Categories"},
     *     summary="Update Category",
     *     description="Update Category",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="title", type="string", example="Category 1"),
     *              @OA\Property(property="resataurant_id", type="integer", example=2),
     *          ),
     *      ),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200, description="Update Product"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
 public function update(CategoryRequest $request, $id): JsonResponse
 {
     try {
         $data = $this->repository->update($id, $request->all());
         if (is_null($data))
             return $this->responseError(null, 'Category Not Found', Response::HTTP_NOT_FOUND);

         return $this->responseSuccess($data, 'Category Updated Successfully !');
     } catch (\Exception $e) {
         return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
     }
 }
/**
 * Delete a Category
 * @OA\Delete (
 *     path="/api/categories/delete/{id}",
 *     tags={"Categories"},
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
        $Category  =  $this->repository->getByID($id);
        if (empty($Category )) {
            return $this->responseError(null, 'Category Not Found', Response::HTTP_NOT_FOUND);
        }

        $deleted = $this->repository->delete($id);
        if (!$deleted) {
            return $this->responseError(null, 'Failed to delete the Category .', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->responseSuccess($Category , 'Category  Deleted Successfully !');
    } catch (\Exception $e) {
        return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
}


<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategoriesRequest;
use App\Repositories\SubCategoryRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubCategoryController extends Controller
{
    use ResponseTrait;
    protected $repository;

    public function __construct(SubCategoryRepository $repository)
    {
        $this->middleware('auth:api', ['except' => ['indexAll']]);
        $this->repository = $repository;
    }
    
    /**
     * @OA\Get(
     *     path="/api/subcategories",
     *     tags={"Subcategories"},
     *     summary="List of Subcategories",
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
            return $this->responseSuccess($data, 'SubCategories List Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/subcategories/all",
     *     tags={"Subcategories"},
     *     summary="All Subcategories - Publicly Accessible",
     *     description="All Subcategories - Publicly Accessible",
     *     @OA\Parameter(name="perPage", description="perPage, eg; 20", example=20, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="All Subcategories - Publicly Accessible" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function indexAll(Request $request): JsonResponse
    {
        try {
            $data = $this->repository->getPaginatedData($request->perPage);
            return $this->responseSuccess($data, 'SubCategories List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/subcategories/search",
     *     tags={"Subcategories"},
     *     summary="All Subcategories - Publicly Accessible",
     *     description="All Subcategories - Publicly Accessible",
     *     @OA\Parameter(name="perPage", description="perPage, eg; 20", example=20, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="search", description="search, eg; Test", example="Test", in="query", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="All Subcategories - Publicly Accessible" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $data = $this->repository->search($request->search, $request->perPage);
            return $this->responseSuccess($data, 'SubCategories List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

        /**
     * Create a SubCategory
     * @OA\Post (
     *     path="/api/subcategories/store",
     *     tags={"Subcategories"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          description="Name of the subcategory"
     *                      ),
     *                      @OA\Property(
     *                          property="Parent_Category_id",
     *                          type="integer",
     *                          description="ID of the category who have this subcategory"
     *                      )
     *                 ),
     *                 example={
     *                     "name": "Margherita",
     *                     "Parent_Category_id" : 2
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="Margherita"),
     *              @OA\Property(property="Parent_Category_id", type="integer", example=2),
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
    public function store(SubCategoriesRequest $request): JsonResponse
    {
        try {
            $SubCategory = $this->repository->create($request->all());
            return $this->responseSuccess($SubCategory, 'New SubCategory Created Successfully !');
        } catch (\Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Get a SubCategory
     * @OA\Get (
     *     path="/api/subcategories/show/{id}",
     *     tags={"Subcategories"},
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
     *                  @OA\Property(property="name", type="string", example="Margherita"),
     *                  @OA\Property(property="Parent_Category_id", type="integer", example=2),
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
                 return $this->responseError(null, 'SubCategory Not Found', Response::HTTP_NOT_FOUND);
             }
 
             return $this->responseSuccess($data, 'SubCategory Details Fetch Successfully !');
         } catch (\Exception $e) {
             return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
         }
     }
    /**
 * Update a SubCategoy
 * @OA\Put (
 *     path="/api/subcategories/update/{id}",
 *     tags={"Subcategories"},
 *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          description="Name of the subcategory"
     *                      ),
     *                      @OA\Property(
     *                          property="Parent_Category_id",
     *                          type="integer",
     *                          description="ID of the category who have this subcategory"
     *                      )
     *                 ),
     *                 example={
     *                     "name": "Margherita 1",
     *                     "Parent_Category_id" : 2
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="Margherita 1"),
     *              @OA\Property(property="Parent_Category_id", type="integer", example=2),
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


 public function update(SubCategoriesRequest $request, $id): JsonResponse
 {
     try {
         $data = $this->repository->update($id, $request->all());
         if (is_null($data))
             return $this->responseError(null, 'SubCategory Not Found', Response::HTTP_NOT_FOUND);

         return $this->responseSuccess($data, 'SubCategory Updated Successfully !');
     } catch (\Exception $e) {
         return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
     }
 }
/**
 * Delete a SubCategory
 * @OA\Delete (
 *     path="/api/subcategories/delete/{id}",
 *     tags={"Subcategories"},
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
        $SubCategory  =  $this->repository->getByID($id);
        if (empty($SubCategory )) {
            return $this->responseError(null, 'SubCategory Not Found', Response::HTTP_NOT_FOUND);
        }

        $deleted = $this->repository->delete($id);
        if (!$deleted) {
            return $this->responseError(null, 'Failed to delete the SubCategory .', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->responseSuccess($SubCategory , 'SubCategory  Deleted Successfully !');
    } catch (\Exception $e) {
        return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
}


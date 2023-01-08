<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ResponseTrait;
    protected $repository;

    public function __construct(CategoryRepository $repository)
    {
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
    public function index()
    {
        try{
            $repository = new CategoryRepository();
            return $this->responseSuccess($this->repository->getAll());
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
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
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="name_c", type="string", example="Category 1"),
     *                  @OA\Property(property="id_product", type="integer", example=1),
     *                  @OA\Property(property="created_at", type="string", example="2023-01-01T22:45:03.000000Z"),
     *                  @OA\Property(property="updated_at", type="string", example="2023-01-01T22:45:03.000000Z"),
     *                  @OA\Property(
     *                      property="product",
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="name", type="string", example="Product"),
     *                      @OA\Property(property="id_restaurant", type="integer", example=1),
     *                      @OA\Property(property="created_at", type="string", example="2023-01-01T21:22:00.000000Z"),
     *                      @OA\Property(property="updated_at", type="string", example="2023-01-01T21:26:02.000000Z")
     *                  )
     *              )
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
            $repository = new CategoryRepository();
            return $this->responseSuccess($this->repository->getByid($id));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
    /**
     * Create a Categorie
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
     *                          property="name_c",
     *                          type="string",
     *                          description="Name of the category"
     *                      ),
     *                      @OA\Property(
     *                          property="id_product",
     *                          type="integer",
     *                          description="ID of the product"
     *                      )
     *                 ),
     *                 example={
     *                     "name": "Category 1",
     *                     "id_restaurant": 1
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name_c", type="string", example="Category 1"),
     *              @OA\Property(property="id_product", type="integer", example=1),
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
            $repository = new CategoryRepository();
            return $this->responseSuccess($this->repository->create($request));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
/**
 * Update a Category
 * @OA\Put (
 *     path="/api/categories/update/{id}",
 *     tags={"Categories"},
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
 *                          property="name_c",
 *                          type="string",
 *                          description="Name of the category"
 *                      ),
 *                      @OA\Property(
 *                          property="id_product",
 *                          type="integer",
 *                          description="ID of the product"
 *                      )
 *                 ),
 *                 example={
 *                     "name": "Category 2",
 *                     "id_product": 1
 *                }
 *             )
 *         )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="success",
 *          @OA\JsonContent(
 *              @OA\Property(property="id", type="integer", example=1),
 *              @OA\Property(property="name_c", type="string", example="Category 2"),
 *              @OA\Property(property="id_product", type="integer", example=1),
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
            $repository = new CategoryRepository();
            return $this->responseSuccess($this->repository->update($request,$id));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
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
    public function delete($id)
    {
        try{
            $repository = new CategoryRepository();
            return $this->responseSuccess($this->repository->delete($id));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use Exception;
use App\Repositories\SubCategoryRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    use ResponseTrait;
    protected $repository;

    public function __construct(SubCategoryRepository $repository)
    {
        $this->repository = $repository;
    }
         /**
     * @OA\Get(
     *     path="/api/subcategories",
     *     tags={"SubCategories"},
     *     summary="List of SubCategories",
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
            $repository = new SubCategoryRepository();
            return $this->responseSuccess($this->repository->getAll());
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
   /**
     * Get a SubCategory
     * @OA\Get (
     *     path="/api/subcategories/show/{id}",
     *     tags={"SubCategories"},
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
     *                  @OA\Property(property="name_sc", type="string", example="SubCategory 1"),
     *                  @OA\Property(property="prix", type="number", example=10.99),
     *                  @OA\Property(property="description", type="string", example="This is a description of SubCategory 1"),
     *                  @OA\Property(property="id_categories", type="integer", example=1),
     *                  @OA\Property(property="created_at", type="string", example="2023-01-02T19:05:13.000000Z"),
     *                  @OA\Property(property="updated_at", type="string", example="2023-01-02T19:05:13.000000Z"),
     *                  @OA\Property(
     *                      property="category",
     *                      type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="name_c", type="string", example="Category 1"),
     *                      @OA\Property(property="id_product", type="integer", example=1),
     *                      @OA\Property(property="created_at", type="string", example="2023-01-01T22:45:03.000000Z"),
     *                      @OA\Property(property="updated_at", type="string", example="2023-01-01T22:45:03.000000Z"),
     *              )
     *          )
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
            $repository = new SubCategoryRepository();
            return $this->responseSuccess($this->repository->getByid($id));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
    /**
     * Create a SubCategorie
     * @OA\Post (
     *     path="/api/subcategories/store",
     *     tags={"SubCategories"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name_sc",
     *                          type="string",
     *                          description="Name of the subcategory"
     *                      ),
     *                      @OA\Property(
     *                          property="prix",
     *                          type="number",
     *                          description="Price of the subcategory"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string",
     *                          description="description of the subcategory"
     *                      ),
     *                      @OA\Property(
     *                          property="id_categories",
     *                          type="integer",
     *                          description="ID of the category"
     *                      )
     *                 ),
     *                 example={
     *                     "name_sc" : "SubCategory 1",
     *                     "prix" : 10.99,
     *                     "description" : "This is a description of SubCategory 1",
     *                     "id_restaurant": 1
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="name_sc", type="string", example="SubCategory 1"),
     *              @OA\Property(property="prix", type="number", example=10.99),
     *              @OA\Property(property="description", type="string", example="This is a description of SubCategory 1"),
     *              @OA\Property(property="id_categories", type="integer", example=1),
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
            $repository = new SubCategoryRepository();
            return $this->responseSuccess($this->repository->create($request));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
/**
 * Update a SubCategory
 * @OA\Put (
 *     path="/api/subcategories/update/{id}",
 *     tags={"SubCategories"},
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
     *                          property="name_sc",
     *                          type="string",
     *                          description="Name of the subcategory"
     *                      ),
     *                      @OA\Property(
     *                          property="prix",
     *                          type="number",
     *                          description="Price of the subcategory"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string",
     *                          description="description of the subcategory"
     *                      ),
     *                      @OA\Property(
     *                          property="id_categories",
     *                          type="integer",
     *                          description="ID of the category"
     *                      )
     *                 ),
     *                 example={
     *                     "name_sc" : "SubCategory",
     *                     "prix" : 10.99,
     *                     "description" : "This is a description of SubCategory 1",
     *                     "id_restaurant": 1
     *                }
 *             )
 *         )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="success",
 *          @OA\JsonContent(
 *              @OA\Property(property="name_sc", type="string", example="SubCategory"),
 *              @OA\Property(property="prix", type="number", example=10.99),
 *              @OA\Property(property="description", type="string", example="This is a description of SubCategory 1"),
 *              @OA\Property(property="id_categories", type="integer", example=1),
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
    public function update(Request $request, $id)
    {
        try{
            $repository = new SubCategoryRepository();
            return $this->responseSuccess($this->repository->update($request,$id));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
/**
 * Delete a SubCategory
 * @OA\Delete (
 *     path="/api/subcategories/delete/{id}",
 *     tags={"SubCategories"},
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
            $repository = new SubCategoryRepository();
            return $this->responseSuccess($this->repository->delete($id));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
}

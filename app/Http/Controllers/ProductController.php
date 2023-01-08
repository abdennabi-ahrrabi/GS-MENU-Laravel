<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResponseTrait;
    protected $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }
    
        /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="List of Products",
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
            $repository = new ProductRepository();
            return $this->responseSuccess($this->repository->getAll());
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
    /**
     * Get a Product
     * @OA\Get (
     *     path="/api/products/show/{id}",
     *     tags={"Products"},
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
     *              @OA\Property(property="name", type="string", example="Product 1"),
     *              @OA\Property(property="id_restaurant", type="integer", example=1),
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
            $repository = new ProductRepository();
            return $this->responseSuccess($this->repository->getByid($id));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
    
        /**
     * Create a Product
     * @OA\Post (
     *     path="/api/products/store",
     *     tags={"Products"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          description="Name of the product"
     *                      ),
     *                      @OA\Property(
     *                          property="id_restaurant",
     *                          type="integer",
     *                          description="ID of the restaurant who have this products"
     *                      )
     *                 ),
     *                 example={
     *                     "name": "Product 1",
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
     *              @OA\Property(property="name", type="string", example="Product 1"),
     *              @OA\Property(property="id_restaurant", type="integer", example=1),
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
            $repository = new ProductRepository();
            return $this->responseSuccess($this->repository->create($request));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
    /**
 * Update a Product
 * @OA\Put (
 *     path="/api/products/update/{id}",
 *     tags={"Products"},
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
 *                          property="id_restaurant",
 *                          type="integer",
 *                          description="ID of the user who owns the restaurant"
 *                      )
 *                 ),
 *                 example={
 *                     "name": "Product",
 *                     "id_restaurant": 1
 *                }
 *             )
 *         )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="success",
 *          @OA\JsonContent(
 *              @OA\Property(property="id", type="integer", example=1),
 *              @OA\Property(property="name", type="string", example="Product"),
 *              @OA\Property(property="id_restaurant", type="integer", example=2),
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
            $repository = new ProductRepository();
            return $this->responseSuccess($this->repository->update($request,$id));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
    /**
 * Delete a Product
 * @OA\Delete (
 *     path="/api/products/delete/{id}",
 *     tags={"Products"},
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
            $repository = new ProductRepository();
            return $this->responseSuccess($this->repository->delete($id));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
}


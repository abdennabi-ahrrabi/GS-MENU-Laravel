<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Admin;
use App\Repositories\AdminRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    use ResponseTrait;

    public $adminRepository;
    
    public function __construct(AdminRepository $adminRepository) {
        $this->adminRepository = $adminRepository;
    }


     /**
     * @OA\Get(
     *     path="/api/admins",
     *     tags={"Admin"},
     *     summary="List of Admins",
     *     description="Multiple status values can be provided with comma separated string",
     *     operationId="index",
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
    public function index() :JsonResponse
    {
        try{
            $adminRepository = new AdminRepository();
            return $this->responseSuccess($this->adminRepository->getAll());
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }

    public function show(Admin $admin)
    {
        return $admin;
    }

    /**
     * Create Admin
     * @OA\Post (
     *     path="/api/admins/register",
     *     tags={"Admin"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="username",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "email": "Ahrrabi@example.com",
     *                     "username": "admin",
     *                     "password": "Ahrrabi1234"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="email", type="string", example="admin@example.com"),
     *              @OA\Property(property="username", type="string", example="admin"),
     *              @OA\Property(property="password", type="string", example="$2y$10$Gs3IpiZd4KkmyVF8tSI55ujEoAKe0.eXqQK.QklsERNMHbtfqR2uq"),
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
     * )
     */
    public function register(Request $request)
    {
        try{
            $adminRepository = new AdminRepository();
            return $this->responseSuccess($this->adminRepository->create($request));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
            /**
 * Login
 * @OA\Post (
 *     path="/api/admins/login",
 *     tags={"Admin"},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                      type="object",
 *                      @OA\Property(
 *                          property="email",
 *                          type="string",
 *                          description="Email address of the admin"
 *                      ),
 *                      @OA\Property(
 *                          property="password",
 *                          type="string",
 *                          description="Password of the admin"
 *                      )
 *                 ),
 *                 example={
 *                     "email":"Ahrrabi@example.com",
 *                     "password" : "Ahrrabi1234"
 *                }
 *             )
 *         )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="success",
 *          @OA\JsonContent(
 *              @OA\Property(property="token", type="string", example="true")
 *          )
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="invalid",
 *          @OA\JsonContent(
 *              @OA\Property(property="error", type="string", example="Unauthorized"),
 *              @OA\Property(
 *                  property="email",
 *                  type="array",
 *                  @OA\Items(
 *                      type="string",
 *                      example="The email field is required."
 *                  )
 *              ),
 *              @OA\Property(
 *                  property="password",
 *                  type="array",
 *                  @OA\Items(
 *                      type="string",
 *                      example="The password field is required."
 *                  )
 *              )
 *          )
 *      )
 * )
 */
public function login(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    if ($validator->fails()) {
        return $this->responseError($validator->errors());
    }

    // Attempt to authenticate the admin
    $credentials = $request->only(['email', 'password']);
    if (!$token = auth('admin')->attempt($credentials)) {
        return $this->responseError(['error' => 'Unauthorized']);
    }
    return $this->responseSuccess(['token' => $token]);
}

        /**
     * Update Admin
     * @OA\Put (
     *     path="/api/admins/update/{admin}",
     *     tags={"Admin"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="username",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "email": "abdou@gmail.com",
     *                     "username": "adbo.ah",
     *                     "password": "password"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=5),
     *              @OA\Property(property="email", type="string", example="abdou@gmail.com"),
     *              @OA\Property(property="username", type="string", example="admin"),
     *              @OA\Property(property="password", type="string", example="adbo.ah"),
     *              @OA\Property(property="updated_at", type="string", example="2022-12-28T21:23:09.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2022-12-28T21:34:47.000000Z"),
     *          )
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        try{
            $adminRepository = new AdminRepository();
            return $this->responseSuccess($this->adminRepository->update($request,$id));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }

    /**
     * Delete Admin
     * @OA\Delete (
     *     path="/api/admins/delete/{admin}",
     *     tags={"Admin"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="delete admin success")
     *         )
     *     )
     * )
     */
    public function delete(Admin $admin)
    {
        $admin->delete();

        return response()->json(null, 204);
    }
}

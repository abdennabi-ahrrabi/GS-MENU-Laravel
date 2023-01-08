<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ResponseTrait;

    public $userRepository;
    
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }
    
    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="List of Users",
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
        /*try{
            $userRepository = new UserRepository();
            return $this->responseSuccess($this->userRepository->getAll());
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }*/
        return User::with('restaurants.products')->get();
    }
        /**
     * Create User
     * @OA\Post (
     *     path="/api/users/register",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="username",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="telephone",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "username": "user",
     *                     "password": "password123",
     *                     "email":"johndoe@example.com",
     *                     "telephone": "1234567890"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="username", type="string", example="user"),
     *              @OA\Property(property="password", type="string", example="$2y$10$.Yta5b5uuQntqf.bALbws.TRPWRpeGPeze1NRMIEpyCKBTswRTAlu"),
     *              @OA\Property(property="email", type="string", example="admin@example.com"),
     *              @OA\Property(property="telephone", type="string", example="1234567890"),
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
            $userRepository = new UserRepository();
            return $this->responseSuccess($this->userRepository->create($request));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
    /**
 * Login
 * @OA\Post (
 *     path="/api/users/login",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                      type="object",
 *                      @OA\Property(
 *                          property="email",
 *                          type="string",
 *                          description="Email address of the user"
 *                      ),
 *                      @OA\Property(
 *                          property="password",
 *                          type="string",
 *                          description="Password of the user"
 *                      )
 *                 ),
 *                 example={
 *                     "email" : "johndoe@example.com",
 *                     "password" : "password123"
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
        try{
        $userRepository = new UserRepository();
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->responseError($validator->errors());
        }

        // Attempt to authenticate the user
        $credentials = $request->only(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return $this->responseError(['error' => 'Unauthorized']);
        }
        return $this->responseSuccess(['token' => $token]);
    }catch(Exception $e) {
        return $this->responseError($e->getMessage());
    }
    }
    
    public function show($id)
    {
        try{
            $userRepository = new UserRepository();
            return $this->responseSuccess($this->userRepository->getByid($id));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }

     /**
     * Update User
     * @OA\Put (
     *     path="/api/users/update/{id}",
     *     tags={"Users"},
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
     *                          property="username",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="telephone",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "username": "Abdennabi Ahrrabi",
     *                     "password": "Ahrrabi",
     *                     "email": "Abdennabi-Ahrrabi@outlook.fr",
     *                     "telephone": "0660150740"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="username", type="string", example="Abdennabi Ahrrabi"),
     *              @OA\Property(property="password", type="string", example="Ahrrabi"),
     *              @OA\Property(property="email", type="string", example="Abdennabi-Ahrrabi@outlook.fr"),
     *              @OA\Property(property="telephone", type="string", example="0660150740"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *          )
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        try{
            $userRepository = new UserRepository();
            return $this->responseSuccess($this->userRepository->update($request,$id));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
    /**
     * Delete User
     * @OA\Delete (
     *     path="/api/users/delete/{id}",
     *     tags={"Users"},
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
     *             @OA\Property(property="msg", type="string", example="delete user success")
     *         )
     *     )
     * )
     */
    public function delete($id)
    {
        try{
            $userRepository = new UserRepository();
            return $this->responseSuccess($this->userRepository->delete($id));
        }catch(Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
}

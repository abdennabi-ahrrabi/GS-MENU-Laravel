<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait {
    /**
     * success response.
     * 
     * @param array|object $data
     * @param string $message
     * 
     * @return JsonResponse
     */
    public function responseSuccess($data, $message = "Successful"): JsonResponse{
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'errors' => null
        ]);
    }

    /**
     * Error response.
     * 
     * @param array|object $error
     * @param string $message
     * 
     * @return JsonResponse
     */
    public function responseError($error, $message = "Something went wrong!"): JsonResponse{
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => null,
            'errors' => $error
        ]);
    }
}

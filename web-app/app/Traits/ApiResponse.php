<?php

namespace App\Traits;

trait ApiResponse
{
    /**
     * Return a success response with a custom message and data.
     *
     * @param string|null $message
     * @param array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($message = null, $data = [], $code = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Return a success response with a custom message and data.
     *
     * @param string|null $message
     * @param array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message = null, $errors = [], $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}

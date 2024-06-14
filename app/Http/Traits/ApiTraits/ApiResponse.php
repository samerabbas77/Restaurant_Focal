<?php

namespace App\Http\Traits\ApiTraits;

trait ApiResponse
{
    /**
     * Success response method.
     *
     * @param  mixed   $result
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $message)
    {
        $array = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];

        return response()->json($array, 200);
    }

    /**
     * Error response method.
     *
     * @param  string  $error
     * @param  array   $errorMessages
     * @param  int     $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($error, $errorMessages = [], $status = 500)
    {
        $array = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $array['data'] = $errorMessages;
        }

        return response()->json($array, $status);
    }
}

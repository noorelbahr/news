<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * @param $message
     * @param int $code
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($message, $code = 200, $data = null)
    {
        $responses = [
            'code' => $code,
            'message' => $message
        ];

        if ($data)
            $responses['data'] = $data;

        return response()->json($responses, $code);
    }

    /**
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function fail($message, $code = 400)
    {
        return response()->json([
            'code' => $code,
            'message' => $message
        ], $code);
    }
}

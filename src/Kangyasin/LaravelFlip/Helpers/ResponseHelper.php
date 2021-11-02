<?php

namespace Kangyasin\LaravelFlip\Helpers;

use Illuminate\Http\JsonResponse;

class FlipResponseHelper
{

    /**
     * Formatted Json Response to FrontEnd
     * @param int $code
     * @param $data
     * @param String $response
     * @param $errors
     * @param array $header
     * @return JsonResponse
     */
    public static function json($data, int $code, $response = '', $errors = [], $header = [], $status = 'success'): JsonResponse
    {
        if($code != 200)
        {
            $status = 'failed';
        }
        $response = ['data' => $data, 'flip_response' => $response, 'status' => $status, 'code' => $code];
        return response()->json($response, $code, $header);
    }
}

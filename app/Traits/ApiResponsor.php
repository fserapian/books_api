<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponsor
{

    // Success response
    public function successResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json(['data' => $data], $code);
    }

    // Error response
    public function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
}

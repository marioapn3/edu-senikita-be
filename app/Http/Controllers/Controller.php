<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    public function exceptionError($message, $errors = [], $status = 400)
{
    return response()->json([
        'success' => false,
        'message' => $message,
        'errors' => $errors,
    ], $status);
}



    public function successResponse($data, $message = 'Success', $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }


    public function respond($data)
    {
        return response()->json($data);
    }
}

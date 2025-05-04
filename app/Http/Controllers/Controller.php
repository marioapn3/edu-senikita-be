<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function exceptionError($e, $exception, $status = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'errors' => $exception,
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

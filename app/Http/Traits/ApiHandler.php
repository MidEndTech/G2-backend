<?php

namespace app\http\Traits;


trait ApiHandler{


    public function successMessage($data, $message = null)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }

    public function unauthorizMessage()
    {
        return response()->json([
            'message' => 'Unauthorizede'
        ],401);
    }
    public function errorMessage($message)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null
        ]);
    }
}





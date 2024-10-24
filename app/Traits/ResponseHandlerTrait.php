<?php

namespace App\Traits;

trait ResponseHandlerTrait
{
    public function successResponse($message, $data = [], $statusCode=200)
    {
        return response([
			'status' => 'success',
			'message' => $message,
			'data' => $data],
			$statusCode
		);
    }

    public function failResponse($message, $error = [], $statusCode=400)
    {
        return response([
			'status' => 'fail',
			'message' => $message,
			'error' => $error
        ],
			$statusCode
		);
    }
}

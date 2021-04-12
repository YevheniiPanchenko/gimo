<?php

namespace Src\Traits;

trait Response
{
    protected function successResponse($data, $message): string
    {
        header('HTTP/1.1 200 OK');
        return json_encode([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function cratedResponse($data): string
    {
        header('HTTP/1.1 201 Created');
        return json_encode([
            'success' => true,
            'message' => 'Created',
            'data' => $data
        ]);
    }

    protected function unauthorizedResponse($data): string
    {
        header('HTTP/1.1 401 Unauthorized');
        return json_encode([
            'success' => false,
            'message' => 'Unauthorize',
            'data' => $data
        ]);
    }

    protected function notFoundResponse(): string
    {
        header('HTTP/1.1 404 Not Found');
        return json_encode([
            'success' => false,
            'message' => 'Not found',
            'data' => null
        ]);
    }

    protected function validationErrorResponse($data): string
    {
        header('HTTP/1.1 422 Unprocessable Entity');
        return json_encode([
            'success' => false,
            'message' => 'Unprocessable Entity',
            'data' => $data
        ]);
    }

    protected function errorResponse(): string
    {
        header('HTTP/1.1 500 Internal Server Error');
        return json_encode([
            'success' => false,
            'message' => 'Something went wrong',
            'data' => null
        ]);
    }
}
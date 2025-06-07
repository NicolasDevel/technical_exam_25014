<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait
{
    public function successResponse(mixed $data, string $message, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function errorResponse(string $message, array $trace = [] , int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {

        return response()->json([
            'message' => $message,
            ...$this->getTrace($trace),
        ], $code);
    }

    private function getTrace(array $trace): array
    {
        return env('APP_DEBUG', true) ? ['trace' => $trace] : [];
    }
}

<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler
{
    use ApiResponseTrait;

    public function handle(Throwable $e): JsonResponse
    {
        $code =  $e->getCode();
        $message = $e->getMessage();
        $trace = $e->getTrace();
        $errors = [];
        switch (get_class($e)) {
            case ValidationException::class:
                $errors = $e->errors();
                $code = Response::HTTP_UNPROCESSABLE_ENTITY;
                break;
            case AuthenticationException::class:
                $code = Response::HTTP_UNAUTHORIZED;
                $message = 'No estas autenticado.';
                break;
            case NotFoundHttpException::class:
                $code = Response::HTTP_NOT_FOUND;
                $message = config('messages.error.show');
                break;
        }

        return $this->errorResponse($message, $errors, $trace, $code);
    }
}

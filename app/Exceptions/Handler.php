<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler
{
    use ApiResponseTrait;

    public function handle(Throwable $e)
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

        }
        return $this->errorResponse($message, $errors, $trace, $code);
    }
}

<?php

namespace App\Infrastructure\Contracts;

use Illuminate\Http\JsonResponse;

interface IAuthContract
{
    public function login(array $credentials): JsonResponse;
    public function logout(): JsonResponse;

}

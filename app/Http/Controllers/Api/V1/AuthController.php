<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\auth\LoginRequest;
use App\Infrastructure\Contracts\IAuthContract;
use App\Infrastructure\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private readonly IAuthContract $authServices)
    {}

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authServices->login($request->validated());
    }

    public function logout(): JsonResponse
    {
        return $this->authServices->logout();
    }
}

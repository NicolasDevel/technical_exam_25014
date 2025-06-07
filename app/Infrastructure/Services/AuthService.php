<?php

namespace App\Infrastructure\Services;

use App\Http\Resources\V1\User\UserResource;
use App\Infrastructure\Contracts\IAuthContract;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthService implements IAuthContract
{
    use ApiResponseTrait;

    public function login(array $credentials): JsonResponse
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->tokens()->delete();
            $token = $user->createToken(env('APP_NAME'));
            return $this->successResponse([
                'token_type' => 'Bearer',
                'token' => $token->plainTextToken,
                'user' => UserResource::make($user),
            ], 'Se ha iniciado sesión correctamente.');
        }
        return $this->errorResponse('Las credenciales son incorrectas.', code: Response::HTTP_UNAUTHORIZED);
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return $this->successResponse(
            [],
            'La sesión ha sido cerrada.',
        );
    }
}

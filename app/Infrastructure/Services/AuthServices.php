<?php

namespace App\Infrastructure\Services;

use App\Http\Resources\V1\User\AuthResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthServices
{
    use ApiResponseTrait;

    public function login(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken(env('APP_NAME'));
            return $this->successResponse([
                'token_type' => 'Bearer',
                'token' => $token->plainTextToken,
                'user' => AuthResource::make($user),
            ], 'Se ha iniciado sesión correctamente.');
        }
        return $this->errorResponse('Las credenciales son incorrectas.', code: Response::HTTP_UNAUTHORIZED);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return $this->successResponse(
            [],
            'La sesión ha sido cerrada.',
        );
    }
}

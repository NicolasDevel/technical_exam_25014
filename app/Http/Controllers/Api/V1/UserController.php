<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\auth\RegisterRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Infrastructure\Contracts\IUserContract;
use App\Infrastructure\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function __construct(private readonly IUserContract $userServices)
    {
    }

    public function store(RegisterRequest $request)
    {
        return $this->successResponse(
            UserResource::make($this->userServices->create($request->validated())),
            'El usuario ha sido creado correctamente',
            Response::HTTP_CREATED
        );
    }
}

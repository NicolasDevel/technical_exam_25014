<?php

use App\Exceptions\Handler;
use App\Http\Middleware\RoleMiddleware;
use App\Infrastructure\Contracts\IAuthContract;
use App\Infrastructure\Contracts\ICategoryContract;
use App\Infrastructure\Contracts\IProductContract;
use App\Infrastructure\Contracts\IUserContract;
use App\Infrastructure\Services\AuthService;
use App\Infrastructure\Services\CategoryService;
use App\Infrastructure\Services\ProductService;
use App\Infrastructure\Services\UserService;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'roles' => RoleMiddleware::class,
        ]);
    })
    ->withBindings([
        IAuthContract::class => AuthService::class,
        IUserContract::class =>  UserService::class,
        ICategoryContract::class =>  CategoryService::class,
        IProductContract::class =>  ProductService::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e) {
            return (new Handler())->handle($e);
        });
    })->create();

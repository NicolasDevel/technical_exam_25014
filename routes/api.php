<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('v1.')->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('logout', [AuthController::class, 'logout'])
            ->middleware('auth:sanctum')
            ->name('logout');
    });

    Route::prefix('user')
        ->name('user.')
        ->group(function () {
        Route::post('/', [UserController::class, 'store'])
            ->name('register');
    });

    Route::prefix('category')
        ->middleware('auth:sanctum')
        ->name('category.')
        ->group(function () {
            Route::post('', [CategoryController::class, 'store'])
                ->middleware('roles:admin')
                ->name('store');
            Route::get('', [CategoryController::class, 'index'])
                ->middleware('roles:admin,user')
                ->name('index');
            Route::get('{category}', [CategoryController::class, 'show'])
                ->middleware('roles:admin,user')
                ->name('show');
            Route::put('{category}', [CategoryController::class, 'update'])
                ->middleware('roles:admin')
                ->name('update');
            Route::delete('{category}', [CategoryController::class, 'destroy'])
                ->middleware('roles:admin')
                ->name('destroy');
        });
});




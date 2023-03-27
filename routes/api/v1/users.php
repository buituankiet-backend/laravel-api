<?php

namespace api;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('auth')
    ->prefix('users/')
    ->name('users.')
    ->group(function (){
        Route::get('', [UserController::class, 'index'])
            ->name('index')
            ->withoutMiddleware('auth');

        Route::get('{user}', [UserController::class, 'show'])->name('show')
//            ->where('user', '[0-9]+');
                ->whereNumber('user');

        Route::post('', [UserController::class, 'store'])->name('store');

        Route::patch('{user}', [UserController::class, 'update'])->name('update');

        Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
    });



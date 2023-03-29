<?php

namespace api;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware([
    //    'auth:api'
]
)
    ->prefix('users/')
    ->name('users.')
    ->group(function (){
        Route::get('', [UserController::class, 'index'])
            ->name('index')
            ->withoutMiddleware('auth');

        Route::get('{id}', [UserController::class, 'show'])->name('show')
//            ->where('user', '[0-9]+');
                ->whereNumber('user');

        Route::post('', [UserController::class, 'store'])->name('store');

        Route::patch('{id}', [UserController::class, 'update'])->name('update');

        Route::delete('{id}', [UserController::class, 'destroy'])->name('destroy');
    });

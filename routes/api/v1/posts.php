<?php

namespace api;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::middleware([
//    'auth:api'
])
    ->prefix('posts')
    ->name('posts.')
    ->group(function (){
        Route::get('', [PostController::class, 'index'])
            ->name('index')
            ->withoutMiddleware('auth');

        Route::get('/{post}', [PostController::class, 'show'])->name('show')
//            ->where('user', '[0-9]+');
                ->whereNumber('post');

        Route::post('', [PostController::class, 'store'])->name('store');

        Route::patch('/{post}', [PostController::class, 'update'])->name('update');

        Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
    });



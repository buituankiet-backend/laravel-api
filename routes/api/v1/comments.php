<?php

namespace api;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

Route::middleware([
    
])
    ->prefix('comments/')
    ->name('comments.')
    ->group(function (){
        Route::get('', [CommentController::class, 'index'])
            ->name('index')
            ->withoutMiddleware('auth');

        Route::get('{comment}', [CommentController::class, 'show'])->name('show');

        Route::post('', [CommentController::class, 'store'])->name('store');

        Route::patch('{comment}', [CommentController::class, 'update'])->name('update');

        Route::delete('{comment}', [CommentController::class, 'destroy'])->name('destroy');
    });

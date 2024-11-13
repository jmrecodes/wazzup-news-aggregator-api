<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsSourceController;
use App\Http\Controllers\NewsCategoryController;
use App\Http\Controllers\NewsAuthorController;
use App\Http\Controllers\UserController;

Route::middleware('throttle:10,1')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
});

Route::middleware('throttle:20,1')->group(function () {
    Route::get('/news', [ArticleController::class, 'index'])->name('articles');
    Route::get('/news/{article}', [ArticleController::class, 'show'])->name('article');
});

Route::middleware(['auth:sanctum', 'throttle:30,1'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');

    Route::resource('news-sources', NewsSourceController::class);

    Route::resource('news-categories', NewsCategoryController::class);

    Route::resource('news-authors', NewsAuthorController::class);

    Route::get('/news-feed', [UserController::class, 'newsFeed'])->name('newsfeed');
});

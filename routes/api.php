<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsSourceController;
use App\Http\Controllers\NewsCategoryController;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');

    Route::resource('news-sources', NewsSourceController::class);

    Route::resource('news-categories', NewsCategoryController::class);
});

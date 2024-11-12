<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// API routes
Route::prefix('api')->group(function () {
    Route::get('register', [UserController::class, 'register']);
    // Add more API routes here
});

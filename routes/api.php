<?php

use App\Http\Controllers\Books\AuthorController;
use App\Http\Controllers\Books\BookController;
use App\Http\Controllers\Books\SubjectController;
use App\Http\Controllers\Users\AuthController;
use App\Http\Controllers\Users\CreateUserController;
use Illuminate\Support\Facades\Route;

# API Doc
Route::get('/doc', static function () {
    return view('openapi');
});

# Public routes
Route::post('users', CreateUserController::class);
Route::post('auth', AuthController::class);

# Private routes
Route::middleware('auth:api')->group(function () {
    Route::apiResource('authors', AuthorController::class);
    Route::apiResource('subjects', SubjectController::class);
    Route::apiResource('books', BookController::class);
});

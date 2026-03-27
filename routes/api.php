<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

// Public Route for Authentication
Route::post('/login', array(ApiController::class, 'login'));

// Protected Routes (Require Sanctum Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    
    // 1. Full RESTful CRUD for Posts (Handles GET, POST, PUT, PATCH, DELETE)
    Route::apiResource('posts', ApiController::class);

    // 2. Nested Route for Post Comments
    Route::get('/posts/{post}/comments', array(ApiController::class, 'getPostComments'));

    // 3. Routes for the remaining JSONPlaceholder resources
    Route::get('/comments', array(ApiController::class, 'getComments'));
    Route::get('/albums', array(ApiController::class, 'getAlbums'));
    Route::get('/photos', array(ApiController::class, 'getPhotos'));
    Route::get('/todos', array(ApiController::class, 'getTodos'));
    Route::get('/users', array(ApiController::class, 'getUsers'));
});
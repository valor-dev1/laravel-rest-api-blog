<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


require __DIR__.'/auth.php';

Route::middleware(['auth:sanctum'])->get('/profile', [UserController::class, 'profile']);
Route::middleware('auth:sanctum')->apiResource('users', UserController::class);
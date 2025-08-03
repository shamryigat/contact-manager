<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactApiController;
use App\Http\Controllers\Api\AuthController;

// ✅ Public authentication routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// ✅ Protected routes (require token)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('contacts', ContactApiController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});

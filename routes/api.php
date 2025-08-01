<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactApiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('contacts', ContactApiController::class);
});
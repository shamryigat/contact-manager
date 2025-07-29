<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Api\ContactApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 🔹 Authenticated Web Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ContactController::class, 'dashboard'])->name('dashboard');

    // Web Contact CRUD
    Route::resource('contacts', ContactController::class);

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🔹 API Routes (with name prefix to avoid conflicts)
Route::prefix('api')->name('api.')->group(function () {
    Route::apiResource('contacts', ContactApiController::class);
});

require __DIR__.'/auth.php';

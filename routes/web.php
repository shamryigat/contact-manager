<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Api\ContactApiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

Route::get('/', function () {
    return view('welcome');
});

// 🔹 Authenticated Web Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ContactController::class, 'dashboard'])->name('dashboard');

    Route::get('/dashboard/refresh-cache', function () {
        Cache::forget('total_contacts');
        Cache::forget('recent_contacts');
        return redirect()->route('dashboard')->with('success', 'Dashboard cache refreshed!');
    })->name('dashboard.refresh')->middleware('auth');

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

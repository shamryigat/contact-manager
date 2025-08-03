<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HistoryController;
use App\Exports\ActivityLogsExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return redirect()->route('login');
});

// Protect all routes with auth + verified middleware
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard uses controller logic
    Route::get('/dashboard', [ContactController::class, 'index'])->name('dashboard');

    // This route MUST come before the resource route
    Route::get('/contacts/export', [ContactController::class, 'export'])->name('contacts.export');

    // Contact CRUD
    // We will use the apiResource method for simplicity and better naming
    Route::resource('contacts', ContactController::class);
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/history', [HistoryController::class, 'index'])
    ->middleware('auth')
    ->name('history.activity-history');

Route::get('/history/download', function () {
    return Excel::download(new ActivityLogsExport, 'activity_logs.xlsx');
})->name('history.download')->middleware('auth');

require __DIR__.'/auth.php';
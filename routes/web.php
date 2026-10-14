<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/calendar', function () {
        return view('calendar');
    })->name('calendar');

    Route::get('/attendance', function () {
        return view('attendance');
    })->name('attendance');

    Route::get('/classes', function () {
        return view('classes');
    })->name('classes');

    Route::get('/class-sessions', function () {
        return view('class_sessions');
    })->name('class_sessions');

    Route::get('/students', function () {
        return view('students');
    })->name('students');

    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');
});

require __DIR__.'/auth.php';

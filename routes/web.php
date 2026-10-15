<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassSessionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
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

    // Locations
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
    Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
    Route::put('/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
    Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');

    // Classes
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
    Route::post('/classes', [ClassController::class, 'store'])->name('classes.store');
    Route::put('/classes/{class}', [ClassController::class, 'update'])->name('classes.update');
    Route::delete('/classes/{class}', [ClassController::class, 'destroy'])->name('classes.destroy');




    // Students
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');



    // class sessions
    Route::get('/class-sessions', [ClassSessionController::class, 'index'])->name('class-sessions.index');
    Route::get('/class-sessions/data', [ClassSessionController::class, 'data'])->name('class-sessions.data');
    Route::patch('/class-sessions/{classSession}/cancel', [ClassSessionController::class, 'cancel'])->name('class-sessions.cancel');



    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/sessions', [AttendanceController::class, 'sessions'])->name('attendance.sessions');
    Route::get('/attendance/students', [AttendanceController::class, 'students'])->name('attendance.students');
    Route::get('/attendance/student-monthly-details', [AttendanceController::class, 'studentMonthlyDetails'])->name('attendance.student-monthly-details');
    Route::post('/attendance/save', [AttendanceController::class, 'save'])->name('attendance.save');
});

require __DIR__ . '/auth.php';

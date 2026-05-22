<?php

use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Instructor Read and Details
Route::get('/dashboard', [InstructorController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Instructor Details
Route::get('/instructor/details/{instructorId}', [InstructorController::class, 'details'])
    ->middleware(['auth', 'verified'])
    ->name('instructor.details');

// Instructor Vehicle Edit
Route::get('/vehicle/{instructorId}/{vehicleId}/edit', [VehicleController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->name('vehicle.edit');

Route::put('/vehicle/{instructorId}/{vehicleId}', [VehicleController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('vehicle.update');

// Vehicle Read
Route::get('/vehicle/{instructorId}', [VehicleController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('vehicle.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

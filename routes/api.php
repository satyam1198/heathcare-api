<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HealthcareProfessionalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {  
    Route::post('/appointments', [AppointmentController::class, 'book']);
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel']);
    Route::patch('/appointments/{id}/complete', [AppointmentController::class, 'markAsCompleted']);

    // Add HealthcareProfessionalController require authentication here
    Route::get('/healthcare-professionals', [HealthcareProfessionalController::class, 'index']);
});
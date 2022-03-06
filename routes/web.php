<?php

use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resources([
        'classes'       => ClassesController::class,
        'students'      => StudentController::class,
        'admissions'    => AdmissionController::class,
    ]);

});

require __DIR__.'/auth.php';

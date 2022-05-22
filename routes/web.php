<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/notice/{notice}', [HomeController::class, 'notice'])->name('page.notice');
Route::get('/class/{class}', [HomeController::class, 'class'])->name('page.class');
Route::get('/admission-form', [HomeController::class, 'admissionForm'])->name('page.admission-form');
Route::get('/admission-form-blank', [HomeController::class, 'admissionFormBlank'])->name('page.admission-form-blank');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('settings/site-setup', [SettingController::class, 'siteSetup'])->name('settings.site-setup');
    Route::get('settings/home-page', [SettingController::class, 'homePage'])->name('settings.home-page');
    Route::get('settings/{setting}/edit', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings/{setting}', [SettingController::class, 'update'])->name('settings.update');
    
    Route::resources([
        'fees'          => FeeController::class,
        'classes'       => ClassesController::class,
        'students'      => StudentController::class,
        'admissions'    => AdmissionController::class,
        'expenses'      => ExpenseController::class,
        'categories'    => CategoryController::class,
        'admins'        => AdminController::class,
        'staff'         => StaffController::class,
        'designations'  => DesignationController::class,
        'notices'       => NoticeController::class,
        'payments'      => PaymentController::class,
    ]);

});

require __DIR__.'/auth.php';

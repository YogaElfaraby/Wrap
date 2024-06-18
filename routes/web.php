<?php
// routes/web.php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientAuthController;
use App\Http\Controllers\DoctorAuthController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Doctor\DoctorController;


Route::get('/', function () {
    return view('index');
})->name('home');

// Routes untuk autentikasi
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);
// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/signup', [PatientAuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [PatientAuthController::class, 'signup']);
Route::get('/patient/login', [PatientAuthController::class, 'showLoginForm'])->name('patient.login');
Route::post('/patient/login', [PatientAuthController::class, 'login']);
Route::get('/logout', [PatientAuthController::class, 'logout'])->name('logout');

Route::get('/doctor/login', [DoctorAuthController::class, 'showLoginForm'])->name('doctor.login');
Route::post('/doctor/login', [DoctorAuthController::class, 'login']);
Route::post('/doctor/logout', [DoctorAuthController::class, 'logout'])->name('doctor.logout');
// Route untuk upload file
Route::post('/upload/file', [App\Http\Controllers\UploadController::class, 'upload'])->name('upload.file');

// Route untuk appointment dan settings (mungkin membutuhkan controller yang sesuai)
// Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment.index');
// Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

// Group middleware auth untuk route patient
Route::middleware(['auth'])->prefix('patient')->group(function () {
    Route::get('/index', [PatientController::class, 'index'])->name('patient.index');
    Route::get('/doctors', [PatientController::class, 'doctors'])->name('patient.doctors');
    Route::get('/schedule', [PatientController::class, 'schedule'])->name('patient.schedule');
    Route::get('/search-schedule', [PatientController::class, 'searchSchedule'])->name('patient.searchSchedule');
    Route::get('/appointment', [PatientController::class, 'appointment'])->name('patient.appointment');
    Route::get('/setting', [PatientController::class, 'setting'])->name('patient.settings');
    Route::post('/edit-user', [PatientController::class, 'editUser'])->name('patient.edit-user');
    Route::post('/delete-account', [PatientController::class, 'deleteAccount'])->name('patient.delete-account');
    // Tambahkan route lainnya sesuai kebutuhan
});
// Group middleware auth untuk route doctor
Route::middleware(['auth:doctor'])->prefix('doctor')->group(function () {
    Route::get('/index', [DoctorController::class, 'index'])->name('doctor.index');
    // Tambahkan route lainnya sesuai kebutuhan untuk dokter
});
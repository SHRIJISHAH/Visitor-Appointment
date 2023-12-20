<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuperadminVerification;

// Add the following routes for login and OTP verification
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/verify-otp', [AuthController::class, 'showOtpVerificationForm']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

// User Routes
Route::middleware(['auth.user'])->group(function () {
    Route::view('/appointment/calendar', 'appointment.calendar');

    Route::get('/appointment', [AppointmentController::class, 'showForm']);
    Route::post('/appointment', [AppointmentController::class, 'store']);
    Route::get('/appointment/{token}', [AppointmentController::class, 'showByToken'])->name('appointment.show');
    Route::get('/appointment/qrcode/{token}', [AppointmentController::class, 'showQRCode'])->name('appointment.qrcode');
    Route::get('/appointment/date/{date}', [AppointmentController::class, 'getAppointmentsByDate']);
    Route::post('/logout', [AppointmentController::class, 'logoutUser'])->name('logout');
    Route::get('/appointments/{date}', [AppointmentController::class, 'getAppointmentsByDate']);
});

// Admin Dashboard
Route::middleware(['auth.admin'])->group(function () {
    Route::view('/admin/dashboard', 'admin.dashboard');

    Route::get('/admin/register', [AdminController::class, 'showRegistrationForm'])->name('admin.register.form');
    Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register');
    // Route::get('/admin/register', [AdminController::class, 'showRegistrationForm'])->name('admin.register.form');
    // Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register.submit');
    Route::get('/admin/add-user', [AdminController::class, 'showAddUserForm'])->name('admin.add-user.form');
    Route::post('/admin/add-user', [AdminController::class, 'addUser'])->name('admin.add-user');
    Route::get('/admin/all-appointments', [AdminController::class, 'showAllAppointments'])->name('admin.all-appointments');
    Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.manage-users');
    Route::get('/admin/show-all-users', [AdminController::class, 'showAllUsers'])->name('admin.show-all-users');
    Route::get('/admin/show-user/{id}', [AdminController::class, 'showUser'])->name('admin.show-user');
    Route::get('/admin/edit-user/{id}', [AdminController::class, 'editUser'])->name('admin.edit-user');
    Route::post('/admin/update-user/{id}', [AdminController::class, 'updateUser'])->name('admin.update-user');
    Route::get('/admin/delete-user/{id}', [AdminController::class, 'deleteUserConfirmation'])->name('admin.delete-user');
    Route::post('/admin/confirm-delete-user/{id}', [AdminController::class, 'confirmDeleteUser'])->name('admin.confirm-delete-user');
    Route::post('/admin/logout', [AdminController::class, 'logoutAdmin'])->name('admin.logout');
});

Route::get('/scan-qr', [QRCodeController::class, 'showScanner'])->name('scan-qr');
Route::post('/scan-qr', [QRCodeController::class, 'scanQRCode'])->name('scan-qr.process');
Route::post('/log-qr-code-scan', [QRCodeController::class, 'logQrCodeScan']);
Route::get('/scan', [QRCodeController::class, 'showScanner'])->name('qr-code-scanner');

// Provider Routes
Route::get('/provider/login', [ProviderController::class, 'showLoginForm']);
Route::post('/provider/login', [ProviderController::class, 'login']);
Route::get('/provider/verify-otp', [ProviderController::class, 'showOtpVerificationForm']);
Route::post('/provider/verify-otp', [ProviderController::class, 'verifyOtp']);

Route::middleware(['auth.provider'])->group(function () {
    Route::get('/provider/dashboard', [ProviderController::class, 'dashboard'])->name('provider.dashboard');
    Route::get('/provider/show-form', [ProviderController::class, 'showForm'])->name('provider.showForm');
    Route::get('/provider/logout', [ProviderController::class, 'logoutProvider']);
    Route::get('/provider/show-superadmins', [ProviderController::class, 'showSuperadmins'])->name('provider.showSuperadmins');
    Route::get('/provider/organizations', [ProviderController::class, 'showOrganizations'])->name('provider.organizations');
    Route::get('/provider/create-organization', [ProviderController::class, 'showForm'])->name('provider.showForm');
    Route::post('/provider/create-organization', [ProviderController::class, 'addOrganization'])->name('provider.create-organization');
});

// Superadmin Routes
Route::middleware(['auth.superadmin'])->group(function () {
    Route::view('/superadmin/dashboard', 'superadmin.dashboard');

    Route::post('/superadmin/logout', [SuperadminController::class, 'logout'])->name('superadmin.logout');
    Route::get('/superadmin/manage-admins', [SuperadminController::class, 'manageAdmins']);
});
Route::get('/superadmin/verify/{token}', [SuperadminController::class, 'showVerificationForm'])->name('superadmin.showVerificationForm');
Route::post('/superadmin/verify', [SuperadminController::class, 'verify'])->name('superadmin.verify');

// Organization Routes
Route::get('/organization/{id}', [OrganizationController::class, 'show']);
Route::get('/organization/{id}/edit', [OrganizationController::class, 'edit']);
Route::put('/organization/{id}', [OrganizationController::class, 'update']);
Route::delete('/organization/{id}', [OrganizationController::class, 'destroy']);

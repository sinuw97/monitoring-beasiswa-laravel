<?php

use App\Http\Controllers\admin\auth\AuthAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mahasiswa\auth\AuthMahasiswaController;
use App\Http\Controllers\mahasiswa\dashboard\DashboardMahasiswaController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('mahasiswa')->group(function () {
    Route::get('/login', [AuthMahasiswaController::class, 'showLogin'])->name('mahasiswa.login');
    Route::post('/login', [AuthMahasiswaController::class, 'login']);
    Route::post('/logout', [AuthMahasiswaController::class, 'logout'])->name('mahasiswa.logout');

    Route::middleware('mahasiswa')->group(function () {
        Route::get('/dashboard', [DashboardMahasiswaController::class, 'showDashboard'])->name('mahasiswa.dashboard');
    });
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthAdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthAdminController::class, 'login']);
    Route::post('/logout', [AuthAdminController::class, 'logout'])->name('admin.logout');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard');
    });
});
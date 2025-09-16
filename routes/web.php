<?php

use App\Http\Controllers\admin\auth\AuthAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mahasiswa\auth\AuthMahasiswaController;
use App\Http\Controllers\mahasiswa\dashboard\DashboardMahasiswaController;
use App\Http\Controllers\mahasiswa\monev\PengisianMonevController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('mahasiswa')->group(function () {
    Route::get('/login', [AuthMahasiswaController::class, 'showLogin'])->name('mahasiswa.login');
    Route::post('/login', [AuthMahasiswaController::class, 'login']);
    Route::post('/logout', [AuthMahasiswaController::class, 'logout'])->name('mahasiswa.logout');

    Route::middleware('mahasiswa')->group(function () {
        Route::get('/dashboard', [DashboardMahasiswaController::class, 'showDashboard'])->name('mahasiswa.dashboard');
        Route::get('/halaman-pengisian-monev', [PengisianMonevController::class, 'showHalaman'])->name('mahasiswa.laporan-monev');
        Route::post('/buat-laporan', [PengisianMonevController::class, 'buatLaporanBaru'])->name('mahasiswa.buat-laporan');
        Route::get('/isi-monev/{laporanId}', [PengisianMonevController::class, 'showHalamanIsiMonev'])->name('mahasiswa.isi-monev');
        Route::post('/isi-monev/{laporanId}/academic-reports', [PengisianMonevController::class, 'submitNilaiIPKnIPS'])->name('laporan.academic-reports.store');
        Route::post('/isi-monev/{laporanId}/academic-activities', [PengisianMonevController::class, 'submitKegAKademik'])->name('laporan.academic-activities.store');
        Route::post('/isi-monev/{laporanId}/organization-activities',[PengisianMonevController::class,'submitKegOrg'])->name('laporan.org-activities.store');
        Route::post('/isi-monev/{laporanId}/committee-activities',[PengisianMonevController::class,'submitKegKomite'])->name('laporan.committee-activities.store');
        Route::post('/isi-monev/{laporanId}/achievements',[PengisianMonevController::class,'submitAchievemnts'])->name('laporan.achievements.store');
        Route::post('/isi-monev/{laporanId}/independent-activities',[PengisianMonevController::class,'submitKegMandiri'])->name('laporan.independent-activities.store');
        Route::post('/isi-monev/{laporanId}/evaluations',[PengisianMonevController::class,'submitEvaluasi'])->name('laporan.evaluations.store');
        Route::post('/isi-monev/{laporanId}/next-semester-report',[PengisianMonevController::class,'submitTargetIPSnIPK'])->name('laporan.next-semester-reports.store');
        Route::post('/isi-monev/{laporanId}/next-semester-activities',[PengisianMonevController::class,'submitTargetKegAkademik'])->name('laporan.next-smt-activities.store');
        Route::post('/isi-monev/{laporanId}/next-semester-achievements',[PengisianMonevController::class,'submitTargetAchievements'])->name('laporan.next-smt-achievements.store');
        Route::post('/isi-monev/{laporanId}/next-semester-independent',[PengisianMonevController::class,'submitTargetKegMandiri'])->name('laporan.next-smt-independent.store');
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

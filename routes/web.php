<?php

use App\Http\Controllers\admin\auth\AuthAdminController;
use App\Http\Controllers\auth\GoogleAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mahasiswa\auth\AuthMahasiswaController;
use App\Http\Controllers\mahasiswa\dashboard\DashboardMahasiswaController;
use App\Http\Controllers\mahasiswa\monev\HapusDataMonevController;
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
        Route::post('/buat-laporan/{semesterId}', [PengisianMonevController::class, 'buatLaporanBaru'])->name('mahasiswa.buat-laporan');
        Route::get('/laporan/{laporanId}', [PengisianMonevController::class, 'showHalamanIsiMonev'])->name('mahasiswa.lihat-laporan');
        // Tambah data
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
        // Edit data
        Route::put('/laporan/academic-reports/{idData}', [PengisianMonevController::class, 'updateNilaiIPKnIPS'])->name('laporan.academic-reports.update');
        Route::put('/laporan/academic-activities/{idData}', [PengisianMonevController::class, 'updateKegAKademik'])->name('laporan.academic-activities.update');
        Route::put('/laporan/org-activities/{idData}', [PengisianMonevController::class, 'updateKegOrg'])->name('laporan.org-activities.update');
        Route::put('/laporan/committee-activities/{idData}', [PengisianMonevController::class, 'updateKegKomite'])->name('laporan.committee-activities.update');
        Route::put('/laporan/achievements/{idData}', [PengisianMonevController::class, 'updateAchievemnts'])->name('laporan.achievements.update');
        Route::put('/laporan/independent-activities/{idData}', [PengisianMonevController::class, 'updateKegMandiri'])->name('laporan.independent-activities.update');
        Route::put('/laporan/evaluations/{idData}', [PengisianMonevController::class, 'updateEvaluasi'])->name('laporan.evaluations.update');
        Route::put('/laporan/next-semester-report/{idData}', [PengisianMonevController::class, 'updateTargetIPSnIPK'])->name('laporan.next-semester-reports.update');
        Route::put('/laporan/next-semester-activities/{idData}', [PengisianMonevController::class, 'updateTargetKegAkademik'])->name('laporan.next-smt-activities.update');
        Route::put('/laporan/next-semester-achievements/{idData}', [PengisianMonevController::class, 'updateTargetAchievements'])->name('laporan.next-smt-achievements.update');
        Route::put('/laporan/next-semester-independent/{idData}', [PengisianMonevController::class, 'updateTargetKegMandiri'])->name('laporan.next-smt-independent.update');

        // Ajukan laporan
        Route::put('/laporan/{laporanId}/ajukan-laporan', [PengisianMonevController::class, 'ajukanLaporanMonev'])->name('laporan.ajukan');
        
        // Hapus
        Route::delete('/laporan/academic-reports/{idData}/hapus', [HapusDataMonevController::class, 'hapusDataAcademicReport'])->name('laporan.academic-reports.delete');
        Route::delete('/laporan/academic-activities/{idData}/hapus', [HapusDataMonevController::class, 'hapusDataAcademicActivities'])->name('laporan.academic-activities.delete');
        Route::delete('/laporan/org-activities/{idData}/hapus', [HapusDataMonevController::class, 'hapusDataOrganizationActivities'])->name('laporan.org-activities.delete');
        Route::delete('/laporan/committee-activities/{idData}/hapus', [HapusDataMonevController::class, 'hapusDataCommitteeActivities'])->name('laporan.committee-activities.hapus');
        Route::delete('/laporan/achievements/{idData}/hapus', [HapusDataMonevController::class, 'hapusDataAchievement'])->name('laporan.achievements.hapus');
        Route::delete('/laporan/independent-activities/{idData}/hapus', [HapusDataMonevController::class, 'hapusDataIndependentActivities'])->name('laporan.independent-activities.hapus');
        Route::delete('/laporan/evaluations/{idData}/hapus', [HapusDataMonevController::class, 'hapusDataEvaluasi'])->name('laporan.evaluations.hapus');
        Route::delete('/laporan/next-semester-report/{idData}/hapus', [HapusDataMonevController::class, 'hapusDataNextReport'])->name('laporan.next-semester-reports.hapus');
        Route::delete('/laporan/next-semester-activities/{idData}/hapus', [HapusDataMonevController::class, 'hapusDataNextActivities'])->name('laporan.next-smt-activities.hapus');
        Route::delete('/laporan/next-semester-achievements/{idData}/hapus', [HapusDataMonevController::class, 'hapusDataNextAchievement'])->name('laporan.next-smt-achievements.hapus');
        Route::delete('/laporan/next-semester-independent/{idData}/hapus', [HapusDataMonevController::class, 'hapusDataNextIndependent'])->name('laporan.next-smt-independent.hapus');
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

Route::get('/google/auth', [GoogleAuthController::class, 'redirectToGoogle']);
Route::get('/google/callback', [GoogleAuthController::class, 'handlegoogleCallback']);  
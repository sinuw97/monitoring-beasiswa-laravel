<?php

use App\Http\Controllers\admin\auth\AuthAdminController;
use App\Http\Controllers\auth\GoogleAuthController;
use App\Http\Controllers\mahasiswa\monev\AchievementsMonevController;
use App\Http\Controllers\mahasiswa\monev\EvaluationsMonevController;
use App\Http\Controllers\mahasiswa\monev\NilaiIPSnIPKMonevController;
use App\Http\Controllers\mahasiswa\monev\OrgActivitiesMonevController;
use App\Http\Controllers\mahasiswa\monev\TargetIndeActMonevController;
use App\Http\Controllers\mahasiswa\monev\TargetIPSnIPKMonevController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mahasiswa\auth\AuthMahasiswaController;
use App\Http\Controllers\mahasiswa\dashboard\DashboardMahasiswaController;
use App\Http\Controllers\mahasiswa\monev\PengisianMonevController;
use App\Http\Controllers\admin\dashboard\DashboardAdminController;
use App\Http\Controllers\admin\dashboard\DataMahasiswaController;
use App\Http\Controllers\admin\dashboard\LaporanMonevController;
use App\Http\Controllers\mahasiswa\laporan\DetailLaporanMonevController;
use App\Http\Controllers\mahasiswa\laporan\RevisiLaporanController;
use App\Http\Controllers\mahasiswa\profile\ProfilMahasiswaController;
use App\Http\Controllers\mahasiswa\laporan\RiwayatLaporanController;
use App\Http\Controllers\mahasiswa\monev\AcademicActMonevController;
use App\Http\Controllers\mahasiswa\monev\CommitteeActivitiesMonevController;
use App\Http\Controllers\mahasiswa\monev\IndependentActivitiesMonevController;
use App\Http\Controllers\mahasiswa\monev\TargetAcademicActMonevController;
use App\Http\Controllers\mahasiswa\monev\TargetAchievementsMonevController;
use App\Http\Controllers\mahasiswa\profile\GantiPasswordController;
use App\Http\Controllers\admin\PengumumanController;

Route::get('/', function () {
    $pengumuman = \App\Models\Pengumuman::where('is_active', true)->latest()->get();
    return view('welcome', compact('pengumuman'));
});

Route::prefix('mahasiswa')->group(function () {
    Route::get('/login', [AuthMahasiswaController::class, 'showLogin'])->name('mahasiswa.login');
    Route::post('/login', [AuthMahasiswaController::class, 'login']);
    Route::post('/logout', [AuthMahasiswaController::class, 'logout'])->name('mahasiswa.logout');

    Route::middleware('mahasiswa')->group(function () {
        Route::get('/dashboard', [DashboardMahasiswaController::class, 'showDashboard'])->name('mahasiswa.dashboard');
        Route::get('/halaman-pengisian-monev', [PengisianMonevController::class, 'showHalaman'])->name('mahasiswa.laporan-monev');
        Route::post('/buat-laporan/{semesterId}/{semesterSekarang}', [PengisianMonevController::class, 'buatLaporanBaru'])->name('mahasiswa.buat-laporan');
        Route::get('/laporan/{laporanId}', [PengisianMonevController::class, 'showHalamanIsiMonev'])->name('mahasiswa.lihat-laporan');

        // Riwayat Laporan
        Route::get('/riwayat-laporan/{laporanId}',[DetailLaporanMonevController::class, 'showHalamanDetailLaporan'])->name('mahasiswa.detail-laporan');

        // Revisi Laporan
        Route::get('/riwayat-laporan/{laporanId}/revisi', [RevisiLaporanController::class, 'showHalamanRevisi'])->name('mahasiswa.revisi-laporan');

        // Tambah data
        Route::post('/isi-monev/{laporanId}/academic-reports', [NilaiIPSnIPKMonevController::class, 'submitNilaiIPKnIPS'])->name('laporan.academic-reports.store');
        Route::post('/isi-monev/{laporanId}/academic-activities', [AcademicActMonevController::class, 'submitKegAKademik'])->name('laporan.academic-activities.store');
        Route::post('/isi-monev/{laporanId}/organization-activities',[OrgActivitiesMonevController::class,'submitKegOrg'])->name('laporan.org-activities.store');
        Route::post('/isi-monev/{laporanId}/committee-activities',[CommitteeActivitiesMonevController::class,'submitKegKomite'])->name('laporan.committee-activities.store');
        Route::post('/isi-monev/{laporanId}/achievements',[AchievementsMonevController::class,'submitAchievemnts'])->name('laporan.achievements.store');
        Route::post('/isi-monev/{laporanId}/independent-activities',[IndependentActivitiesMonevController::class,'submitKegMandiri'])->name('laporan.independent-activities.store');
        Route::post('/isi-monev/{laporanId}/evaluations',[EvaluationsMonevController::class,'submitEvaluasi'])->name('laporan.evaluations.store');
        Route::post('/isi-monev/{laporanId}/next-semester-report',[TargetIPSnIPKMonevController::class,'submitTargetIPSnIPK'])->name('laporan.next-semester-reports.store');
        Route::post('/isi-monev/{laporanId}/next-semester-activities',[TargetAcademicActMonevController::class,'submitTargetKegAkademik'])->name('laporan.next-smt-activities.store');
        Route::post('/isi-monev/{laporanId}/next-semester-achievements',[TargetAchievementsMonevController::class,'submitTargetAchievements'])->name('laporan.next-smt-achievements.store');
        Route::post('/isi-monev/{laporanId}/next-semester-independent',[TargetIndeActMonevController::class,'submitTargetKegMandiri'])->name('laporan.next-smt-independent.store');

        // Edit data
        Route::put('/laporan/academic-reports/{idData}', [NilaiIPSnIPKMonevController::class, 'updateNilaiIPKnIPS'])->name('laporan.academic-reports.update');
        Route::put('/laporan/academic-activities/{idData}', [AcademicActMonevController::class, 'updateKegAKademik'])->name('laporan.academic-activities.update');
        Route::put('/laporan/org-activities/{idData}', [OrgActivitiesMonevController::class, 'updateKegOrg'])->name('laporan.org-activities.update');
        Route::put('/laporan/committee-activities/{idData}', [CommitteeActivitiesMonevController::class, 'updateKegKomite'])->name('laporan.committee-activities.update');
        Route::put('/laporan/achievements/{idData}', [AchievementsMonevController::class, 'updateAchievemnts'])->name('laporan.achievements.update');
        Route::put('/laporan/independent-activities/{idData}', [IndependentActivitiesMonevController::class, 'updateKegMandiri'])->name('laporan.independent-activities.update');
        Route::put('/laporan/evaluations/{idData}', [EvaluationsMonevController::class, 'updateEvaluasi'])->name('laporan.evaluations.update');
        Route::put('/laporan/next-semester-report/{idData}', [TargetIPSnIPKMonevController::class, 'updateTargetIPSnIPK'])->name('laporan.next-semester-reports.update');
        Route::put('/laporan/next-semester-activities/{idData}', [TargetAcademicActMonevController::class, 'updateTargetKegAkademik'])->name('laporan.next-smt-activities.update');
        Route::put('/laporan/next-semester-achievements/{idData}', [TargetAchievementsMonevController::class, 'updateTargetAchievements'])->name('laporan.next-smt-achievements.update');
        Route::put('/laporan/next-semester-independent/{idData}', [TargetIndeActMonevController::class, 'updateTargetKegMandiri'])->name('laporan.next-smt-independent.update');

        // Ajukan laporan
        Route::put('/laporan/{laporanId}/ajukan-laporan', [PengisianMonevController::class, 'ajukanLaporanMonev'])->name('laporan.ajukan');

        // Hapus
        Route::delete('/laporan/academic-reports/{idData}/hapus', [NilaiIPSnIPKMonevController::class, 'hapusDataAcademicReport'])->name('laporan.academic-reports.delete');
        Route::delete('/laporan/academic-activities/{idData}/hapus', [AcademicActMonevController::class, 'hapusDataAcademicActivities'])->name('laporan.academic-activities.delete');
        Route::delete('/laporan/org-activities/{idData}/hapus', [OrgActivitiesMonevController::class, 'hapusDataOrganizationActivities'])->name('laporan.org-activities.delete');
        Route::delete('/laporan/committee-activities/{idData}/hapus', [CommitteeActivitiesMonevController::class, 'hapusDataCommitteeActivities'])->name('laporan.committee-activities.hapus');
        Route::delete('/laporan/achievements/{idData}/hapus', [AchievementsMonevController::class, 'hapusDataAchievement'])->name('laporan.achievements.hapus');
        Route::delete('/laporan/independent-activities/{idData}/hapus', [IndependentActivitiesMonevController::class, 'hapusDataIndependentActivities'])->name('laporan.independent-activities.hapus');
        Route::delete('/laporan/evaluations/{idData}/hapus', [EvaluationsMonevController::class, 'hapusDataEvaluasi'])->name('laporan.evaluations.hapus');
        Route::delete('/laporan/next-semester-report/{idData}/hapus', [TargetIPSnIPKMonevController::class, 'hapusDataNextReport'])->name('laporan.next-semester-reports.hapus');
        Route::delete('/laporan/next-semester-activities/{idData}/hapus', [TargetAcademicActMonevController::class, 'hapusDataNextActivities'])->name('laporan.next-smt-activities.hapus');
        Route::delete('/laporan/next-semester-achievements/{idData}/hapus', [TargetAchievementsMonevController::class, 'hapusDataNextAchievement'])->name('laporan.next-smt-achievements.hapus');
        Route::delete('/laporan/next-semester-independent/{idData}/hapus', [TargetIndeActMonevController::class, 'hapusDataNextIndependent'])->name('laporan.next-smt-independent.hapus');

        //Profil
        Route::get('/profile', [ProfilMahasiswaController::class, 'show'])->name('mahasiswa.profile');
        Route::get('/mahasiswa/profile/edit', [ProfilMahasiswaController::class, 'edit'])->name('mahasiswa.profile.edit');
        Route::post('/mahasiswa/profile/update', [ProfilMahasiswaController::class, 'update'])->name('mahasiswa.profile.update');
        Route::get('/riwayat-laporan', [RiwayatLaporanController::class, 'index'])->name('mahasiswa.riwayat-laporan');
        // Ganti Password Verivikasi
        Route::post('/ganti-password/submit', [GantiPasswordController::class, 'verifyPassword'])->name('mahasiswa.ganti-pw');
    });
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthAdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthAdminController::class, 'login']);
    Route::post('/logout', [AuthAdminController::class, 'logout'])->name('admin.logout');
    Route::get('/register', [AuthAdminController::class, 'showRegister'])->name('admin.register');
    Route::post('/register', [AuthAdminController::class, 'register'])->name('admin.register.post');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardAdminController::class, 'showDashboard'])->name('admin.dashboard');
        Route::post('/dashboard', [DashboardAdminController::class, 'addPeriode'])->name('admin.dashboard.addPeriode');
        Route::delete('/dashboard/{id}', [DashboardAdminController::class, 'deletePeriode'])->name('admin.dashboard.deletePeriode');
        Route::put('/dashboard/{id}', [DashboardAdminController::class, 'editPeriode'])->name('admin.dashboard.editPeriode');
        Route::put('/dashboard/{id}/aktifkan', [DashboardAdminController::class, 'activatePeriode'])->name('admin.dashboard.activatePeriode');
        Route::put('/dashboard/{id}/nonaktifkan', [DashboardAdminController::class, 'deactivatePeriode'])->name('admin.dashboard.deactivatePeriode');
        Route::get('/laporan/export', [LaporanMonevController::class, 'export'])->name('admin.laporan.export');
        Route::get('/laporan/{id}/export-pdf', [LaporanMonevController::class, 'exportPdf'])->name('admin.laporan.export-pdf');
        Route::get('/laporan', [LaporanMonevController::class, 'index'])->name('admin.laporan');
        Route::get('/laporan/{id}', [LaporanMonevController::class, 'show'])->name('admin.show');
        Route::put('/laporan/{id}', [LaporanMonevController::class, 'update'])->name('admin.update');
        Route::put('/laporan/{id}/academic-reports/{idAcademicReports}', [LaporanMonevController::class, 'academicReports'])->name('admin.adacademic-reports');
        Route::put('/laporan/{id}/academic-activities/{idAcademicActivities}', [LaporanMonevController::class, 'adacademicActivities'])->name('admin.adacademic-activities');
        Route::put('/laporan/{id}/organization-activities/{idOrganizationActivities}', [LaporanMonevController::class, 'organizationActivities'])->name('admin.organization-activities');
        Route::put('/laporan/{id}/committee-activities/{idCommitteeActivities}', [LaporanMonevController::class, 'committeeActivities'])->name('admin.committee-activities');
        Route::put('/laporan/{id}/student-achievements/{idStudentAchievements}', [LaporanMonevController::class, 'studentAchievements'])->name('admin.student-achievements');
        Route::put('/laporan/{id}/independent-activities/{idIndependentActivities}', [LaporanMonevController::class, 'independentActivities'])->name('admin.independent-activities');
        Route::put('/laporan/{id}/evaluations/{idEvaluations}', [LaporanMonevController::class, 'evaluations'])->name('admin.evaluations');
        Route::get('/data-mahasiswa/template', [DataMahasiswaController::class, 'downloadTemplate'])->name('admin.data-mahasiswa.template');
        Route::post('/data-mahasiswa/import', [DataMahasiswaController::class, 'import'])->name('admin.data-mahasiswa.import');
        Route::get('/data-mahasiswa/export', [DataMahasiswaController::class, 'export'])->name('admin.data-mahasiswa.export');
        Route::get('/data-mahasiswa', [DataMahasiswaController::class, 'index'])->name('admin.data-mahasiswa');
        Route::post('/data-mahasiswa', [DataMahasiswaController::class, 'store'])->name('admin.data-mahasiswa.store');
        Route::get('/data-mahasiswa/edit/{id}', [DataMahasiswaController::class, 'edit'])->name('admin.data-mahasiswa.edit');
        Route::put('/data-mahasiswa/edit/{id}', [DataMahasiswaController::class, 'update'])->name('admin.data-mahasiswa.update');
        Route::delete('/data-mahasiswa/{id}', [DataMahasiswaController::class, 'destroy'])->name('admin.data-mahasiswa.destroy');

        // Pengumuman Routes
        Route::resource('pengumuman', PengumumanController::class, ['names' => 'admin.pengumuman']);

        // Profile Routes
        Route::get('/profile', [\App\Http\Controllers\admin\profile\AdminProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::put('/profile', [\App\Http\Controllers\admin\profile\AdminProfileController::class, 'update'])->name('admin.profile.update');
        Route::post('/profile/password', [\App\Http\Controllers\admin\profile\AdminProfileController::class, 'verifyPassword'])->name('admin.profile.password');
    });
});

Route::get('/google/auth', [GoogleAuthController::class, 'redirectToGoogle']);

Route::get('/google/callback', [GoogleAuthController::class, 'handlegoogleCallback']);


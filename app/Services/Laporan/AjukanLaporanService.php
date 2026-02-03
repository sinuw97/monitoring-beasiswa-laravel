<?php

namespace App\Services\Laporan;

use Illuminate\Support\Facades\DB;
use App\Services\Penilaian\KegAkademikService;
use App\Services\Penilaian\KegKomiteService;
use App\Services\Penilaian\KegMandiriService;
use App\Services\Penilaian\KegOrgService;
use App\Services\Penilaian\PrestasiService;

class AjukanLaporanService
{
  public function handle($laporan)
  {
    DB::transaction(function () use ($laporan) {

      // 1. Hitung poin semua kegiatan
      $this->hitungPoin($laporan);

      // 2. Proses laporan keuangan
      $this->prosesKeuangan($laporan);

      // 4. Update status laporan induk
      $laporan->update(['status' => 'Pending']);

      // 5. Update status semua relasi
      $this->updateStatusRelasi($laporan);
    });
  }

  protected function prosesKeuangan($laporan)
  {
    $laporanKeuangan = $laporan->laporanKeuanganMahasiswa;

    if (!$laporanKeuangan) {
      return;
    }

    // update status laporan keuangan
    $laporanKeuangan->update([
      'status' => 'Pending'
    ]);

    // update semua detail keuangan
    $laporanKeuangan->detailKeuanganMahasiswa()
      ->update(['status' => 'Pending']);
  }

  protected function updateStatusRelasi($laporan)
  {
    $relations = [
      'academicReports',
      'academicActivities',
      'committeeActivities',
      'organizationActivities',
      'studentAchievements',
      'independentActivities',
      'evaluations',
      'targetNextSemester',
      'targetAcademicActivities',
      'targetAchievements',
      'targetIndependentActivities',
      'kesanPesanMahasiswa'
    ];

    foreach ($relations as $relation) {
      $laporan->$relation()->update(['status' => 'Pending']);
    }
  }

  protected function hitungPoin($laporan)
  {
    // inisiasi service
    $penilaianKegAkademik = app(KegAkademikService::class);
    $penilaianKegOrganisasi = app(KegOrgService::class);
    $penilaianKegKomite = app(KegKomiteService::class);
    $penilaianPrestasi = app(PrestasiService::class);
    $penilaianKegMandiri = app(KegMandiriService::class);


    // ==== Hitung nilai Kegiatan Akademik ====
    foreach ($laporan->academicActivities as $item) {
      $nilai = $penilaianKegAkademik->hitung($item->activity_type ?? '');
      $item->update(['points' => $nilai]);
    }

    // ==== Hitung nilai Kegiatan Organisasi ====
    foreach ($laporan->organizationActivities as $item) {
      $nilai = $penilaianKegOrganisasi->hitung(
        $item->position ?? '',
        $item->level ?? ''
      );
      $item->update(['points' => $nilai]);
    }

    // ==== Hitung nilai Kegiatan Komite ====
    foreach ($laporan->committeeActivities as $item) {
      $nilai = $penilaianKegKomite->hitung(
        $item->activity_type ?? '',
        $item->level ?? '',
        $item->participation ?? ''
      );
      $item->update(['points' => $nilai]);
    }

    // ==== Hitung nilai Prestasi ====
    foreach ($laporan->studentAchievements as $item) {
      $nilai = $penilaianPrestasi->hitung(
        $item->achievements_type ?? '',
        $item->level ?? '',
        $item->award ?? ''
      );
      $item->update(['points' => $nilai]);
    }

    // ==== Hitung nilai Kegiatan Mandiri ====
    foreach ($laporan->independentActivities as $item) {
      $nilai = $penilaianKegMandiri->hitung($item->activity_type ?? '');
      $item->update(['points' => $nilai]);
    }
  }
}

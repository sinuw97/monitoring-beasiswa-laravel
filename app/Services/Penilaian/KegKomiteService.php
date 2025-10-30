<?php

namespace App\Services\Penilaian;

class KegKomiteService
{
  public function hitung(string $tipeKegiatan, string $tingkat, string $posisi)
  {
    $cleanTipeKegiatan = strtolower($tipeKegiatan ?? '');
    $cleanTingkat = strtolower($tingkat ?? '');
    $cleanPosisi = strtolower($posisi ?? '');

    if (str_starts_with($cleanPosisi, 'divisi')) {
      $cleanPosisi = 'divisi';
    }

    $nilai = [
      'pelatihan kepemimpinan' => [
        'pra dasar' => 3,
        'dasar' => 5,
        'menengah' => 10,
        'lanjut' => 15,
      ],
      'panitia kegiatan perguruan tinggi' => [
        'perguruan tinggi' => [
          'ketua' => 17,
          'wakil ketua' => 12,
          'sekretaris' => 12,
          'bendahara' => 12,
          'divisi' => 6,
          'anggota' => 4,
        ],
        'regional' => [
          'ketua' => 25,
          'wakil ketua' => 17,
          'sekretaris' => 17,
          'bendahara' => 17,
          'divisi' => 8,
          'anggota' => 6,
        ],
        'nasional' => [
          'ketua' => 30,
          'wakil ketua' => 20,
          'sekretaris' => 20,
          'bendahara' => 20,
          'divisi' => 10,
          'anggota' => 7,
        ],
        'internasional' => [
          'ketua' => 49,
          'wakil ketua' => 25,
          'sekretaris' => 25,
          'bendahara' => 25,
          'divisi' => 12,
          'anggota' => 10,
        ],
      ],
    ];

    // Cek apakah tipe valid
    if (!isset($nilai[$cleanTipeKegiatan])) {
        return 0; // or throw exception
    }

    // jika tipe kegiatan "kepemimpinan"
    if ($cleanTipeKegiatan === 'pelatihan kepemimpinan') {
      return $nilai[$cleanTipeKegiatan][$cleanTingkat];
    }

    // jika tipe kegiatan "kepanitiaan"
    if ($cleanTipeKegiatan === 'panitia kegiatan perguruan tinggi') {
      return $nilai[$cleanTipeKegiatan][$cleanTingkat][$cleanPosisi];
    }

    // default
    return 0;
  }
}

<?php

namespace App\Services\Penilaian;

class KegAkademikService
{
  public function hitung(string $tipeKegiatan)
  {
    $cleanTipeKegiatan = strtolower($tipeKegiatan ?? '');

    $nilaiTipe = [
      'salam kampus' => 10,
      'social training camp' => 10,
      'asistensi keagamaan' => 10,
      'program kreativitas mahasiswa' => 10,
      'sertifikasi internasional program studi' => 10,
      'kuliah reguler' => 5,
      'kuliah tamu' => 5,
    ];

    return $nilaiTipe[$cleanTipeKegiatan] ?? 0;
  }
}

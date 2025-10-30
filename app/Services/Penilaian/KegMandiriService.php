<?php

namespace App\Services\Penilaian;

class KegMandiriService
{
  public function hitung(string $tipeKegiatan)
  {
    $cleanTipeKegiatan = strtolower($tipeKegiatan ?? '');

    $nilaiTipe = [
      'magang bersertifikat' => 30,
      'studi independen' => 30,
      'kampus mengajar' => 30,
      'iisma' => 30,
      'pertukaran mahasiswa merdeka' => 30,
      'kkn tematik' => 30,
      'proyek kemanusiaan' => 30,
      'riset atau penelitian' => 30,
    ];

    return $nilaiTipe[$cleanTipeKegiatan] ?? 0;
  }
}
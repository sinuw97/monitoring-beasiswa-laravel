<?php

namespace App\Services\Penilaian;

class KegOrgService
{
  public function hitung(string $posisi, string $tingkat)
  {
    $cleanPosisi = strtolower($posisi ?? '');
    $cleanTingkat = strtolower($tingkat ?? '');

    // tabel nilai posisi per tingkat
    $nilai = [
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
    ];

    // handle posisi yang diawali "divisi ..."
    if (str_starts_with($cleanPosisi, 'divisi')) {
      $cleanPosisi = 'divisi';
    }

    // ambil nilai sesuai tingkat & posisi
    return $nilai[$cleanTingkat][$cleanPosisi] ?? 0;
  }
}

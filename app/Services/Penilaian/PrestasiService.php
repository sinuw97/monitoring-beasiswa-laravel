<?php

namespace App\Services\Penilaian;

class PrestasiService
{
  public function hitung(string $tipePrestasi, string $tingkat, string $raihan)
  {
    $cleanTipePrestasi = strtolower($tipePrestasi);
    $cleanTingkat = strtolower($tingkat);
    $cleanRaihan = strtolower($raihan);

    $nilai = [
      // --- Kompetisi Pemerintahan Individu ---
      'kompetisi pemerintahan individu' => [
        'internasional' => [
          'juara 1' => 120,
          'juara 2' => 110,
          'juara 3' => 100,
          'juara harapan' => 80,
          'peserta terpilih' => 70,
        ],
        'nasional' => [
          'juara 1' => 100,
          'juara 2' => 90,
          'juara 3' => 80,
          'juara harapan' => 70,
          'peserta terpilih' => 50,
        ],
        'regional' => [
          'juara 1' => 70,
          'juara 2' => 60,
          'juara 3' => 50,
          'juara harapan' => 40,
          'peserta terpilih' => 30,
        ],
        'perguruan tinggi' => [
          'juara 1' => 30,
          'juara 2' => 28,
          'juara 3' => 25,
          'juara harapan' => 20,
          'peserta terpilih' => 10,
        ],
      ],

      // --- Kompetisi Pemerintahan Kelompok ---
      'kompetisi pemerintahan kelompok' => [
        'internasional' => [
          'juara 1' => 100,
          'juara 2' => 90,
          'juara 3' => 80,
          'juara harapan' => 70,
          'peserta terpilih' => 50,
        ],
        'nasional' => [
          'juara 1' => 80,
          'juara 2' => 70,
          'juara 3' => 60,
          'juara harapan' => 50,
          'peserta terpilih' => 30,
        ],
        'regional' => [
          'juara 1' => 60,
          'juara 2' => 50,
          'juara 3' => 40,
          'juara harapan' => 30,
          'peserta terpilih' => 10,
        ],
        'perguruan tinggi' => [
          'juara 1' => 20,
          'juara 2' => 15,
          'juara 3' => 10,
          'juara harapan' => 8,
          'peserta terpilih' => 5,
        ],
      ],

      // --- Kompetisi Non-Pemerintahan Individu ---
      'kompetisi non-pemerintahan individu' => [
        'internasional' => [
          'juara 1' => 100,
          'juara 2' => 90,
          'juara 3' => 80,
          'juara harapan' => 70,
          'peserta terpilih' => 50,
        ],
        'nasional' => [
          'juara 1' => 80,
          'juara 2' => 70,
          'juara 3' => 60,
          'juara harapan' => 50,
          'peserta terpilih' => 30,
        ],
        'regional' => [
          'juara 1' => 60,
          'juara 2' => 50,
          'juara 3' => 40,
          'juara harapan' => 30,
          'peserta terpilih' => 10,
        ],
        'perguruan tinggi' => [
          'juara 1' => 20,
          'juara 2' => 15,
          'juara 3' => 10,
          'juara harapan' => 8,
          'peserta terpilih' => 5,
        ],
      ],

      // --- Kompetisi Non-Pemerintahan Kelompok ---
      'kompetisi non-pemerintahan kelompok' => [
        'internasional' => [
          'juara 1' => 80,
          'juara 2' => 70,
          'juara 3' => 60,
          'juara harapan' => 50,
          'peserta terpilih' => 30,
        ],
        'nasional' => [
          'juara 1' => 60,
          'juara 2' => 50,
          'juara 3' => 40,
          'juara harapan' => 30,
          'peserta terpilih' => 10,
        ],
        'regional' => [
          'juara 1' => 40,
          'juara 2' => 25,
          'juara 3' => 20,
          'juara harapan' => 15,
          'peserta terpilih' => 8,
        ],
        'perguruan tinggi' => [
          'juara 1' => 15,
          'juara 2' => 10,
          'juara 3' => 5,
          'juara harapan' => 3,
          'peserta terpilih' => 1,
        ],
      ],

      // --- Juri / Wasit / Pelatih ---
      'juri/wasit/pelatih' => [
        'internasional' => ['juri' => 80, 'wasit' => 80, 'pelatih' => 80],
        'nasional' => ['juri' => 60, 'wasit' => 60, 'pelatih' => 60],
        'regional' => ['juri' => 40, 'wasit' => 40, 'pelatih' => 40],
        'perguruan tinggi' => ['juri' => 20, 'wasit' => 20, 'pelatih' => 20]
      ],

      // --- Anggota Penelitian/Pengabdian ---
      'anggota dalam penelitian/pengabdian' => ['regional' => ['anggota' => 10], 'perguruan tinggi' => ['anggota' => 10]],

      // --- Kegiatan / Forum Ilmiah ---
      'kegiatan/forum ilmiah' => [
        'internasional' => ['pembicara' => 100, 'moderator' => 40, 'peserta' => 20],
        'nasional' => ['pembicara' => 60, 'moderator' => 25, 'peserta' => 15],
        'regional' => ['pembicara' => 40, 'moderator' => 15, 'peserta' => 8],
        'perguruan tinggi' => ['pembicara' => 20, 'moderator' => 10, 'peserta' => 5],
      ],

      // --- Karya Didanai ---
      'karya yang didanai' => [
        'internasional' => ['ketua' => 30, 'anggota' => 15],
        'nasional' => ['ketua' => 25, 'anggota' => 10],
        'regional' => ['ketua' => 20, 'anggota' => 5],
        'perguruan tinggi' => ['ketua' => 8, 'anggota' => 3],
      ],

      // --- Karya Populer Diterbitkan ---
      'karya populer yang diterbitkan' => [
        'internasional' => ['ketua' => 30, 'anggota' => 15],
        'nasional' => ['ketua' => 25, 'anggota' => 10],
        'regional' => ['ketua' => 20, 'anggota' => 5],
        'perguruan tinggi' => ['ketua' => 8, 'anggota' => 3],
      ],

      // --- Penulis Buku ISBN ---
      'penulis buku isbn' => ['nasional' => ['peserta' => 100]],

      // --- Paten ---
      'paten/paten sederhana' => ['nasional' => ['peserta' => 100]],

      // --- Publikasi Jurnal ---
      'publikasi jurnal internasional/nasional' => [
        'internasional' => ['ketua' => 100, 'anggota' => 50],
        'nasional terakreditasi' => ['ketua' => 75, 'anggota' => 35],
        'regional tidak terakreditasi' => ['ketua' => 50, 'anggota' => 20],
      ],

      // --- Kegiatan Sosial / Kerohanian ---
      'ikut kegiatan sosial/kerohanian mewakili institusi' => [
        'internasional' => ['pembicara' => 100, 'moderator' => 40, 'peserta' => 20],
        'nasional' => ['pembicara' => 60, 'moderator' => 25, 'peserta' => 15],
        'regional' => ['pembicara' => 40, 'moderator' => 15, 'peserta' => 8],
      ],

      // --- Lomba Mewakili Institusi ---
      'lomba mewakili insititusi' => [
        'internasional' => ['juara 1' => 80, 'juara 2' => 70, 'juara 3' => 60],
        'nasional' => ['juara 1' => 60, 'juara 2' => 50, 'juara 3' => 40],
        'regional' => ['juara 1' => 40, 'juara 2' => 25, 'juara 3' => 20],
      ],

      // --- Pelatihan Keterampilan di luar PT ---
      'pelatihan keterampilan di luar pt' => ['perguruan tinggi' => ['peserta' => 10]],

      // --- Pengakuan dari Institusi Lain ---
      'pengakuan dari institusi lain' => [
        'internasional' => ["peserta" => 30],
        'nasional' => ["peserta" => 20],
        'regional' => ["peserta" => 10],
      ],
    ];

    // --- Cek tipe valid ---
    if (!isset($nilai[$cleanTipePrestasi])) {
      return 0;
    }

    $dataTipe = $nilai[$cleanTipePrestasi];

    // --- Jika tipe punya tingkat (array di dalamnya) ---
    if (isset($dataTipe[$cleanTingkat])) {
      $dataTingkat = $dataTipe[$cleanTingkat];

      // Kalau $dataTingkat masih array, berarti butuh $raihan (atau posisi)
      if (is_array($dataTingkat)) {
        return $dataTingkat[$cleanRaihan] ?? 0;
      }

      // Kalau bukan array, berarti nilai langsung (tanpa posisi)
      return $dataTingkat ?? 0;
    }

    // --- Jika tipe langsung kasih nilai tanpa tingkat ---
    if (!is_array($dataTipe)) {
      return $dataTipe ?? 0;
    }

    return 0;
  }
}

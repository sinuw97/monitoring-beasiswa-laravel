<?php

namespace Database\Seeders;

use App\Models\semester\Periode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    public function run(): void
    {
        Periode::create([
            'semester_id'=>'SM202201',
            'tahun_akademik'=>'2022/2023',
            'semester'=>'Ganjil',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM202202',
            'tahun_akademik'=>'2022/2023',
            'semester'=>'Genap',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM202301',
            'tahun_akademik'=>'2023/2024',
            'semester'=>'Ganjil',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM202302',
            'tahun_akademik'=>'2023/2024',
            'semester'=>'Genap',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM202401',
            'tahun_akademik'=>'2024/2025',
            'semester'=>'Ganjil',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM202402',
            'tahun_akademik'=>'2024/2025',
            'semester'=>'Genap',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM202501',
            'tahun_akademik'=>'2025/2026',
            'semester'=>'Ganjil',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM202502',
            'tahun_akademik'=>'2025/2026',
            'semester'=>'Genap',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM202601',
            'tahun_akademik'=>'2026/2027',
            'semester'=>'Ganjil',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM202602',
            'tahun_akademik'=>'2026/2027',
            'semester'=>'Genap',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM202701',
            'tahun_akademik'=>'2027/2028',
            'semester'=>'Ganjil',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM202702',
            'tahun_akademik'=>'2027/2028',
            'semester'=>'Genap',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM202801',
            'tahun_akademik'=>'2028/2029',
            'semester'=>'Ganjil',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM202802',
            'tahun_akademik'=>'2028/2029',
            'semester'=>'Genap',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM202901',
            'tahun_akademik'=>'2029/2030',
            'semester'=>'Ganjil',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM202902',
            'tahun_akademik'=>'2029/2030',
            'semester'=>'Genap',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM203001',
            'tahun_akademik'=>'2030/2031',
            'semester'=>'Ganjil',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);

        Periode::create([
            'semester_id'=>'SM203002',
            'tahun_akademik'=>'2030/2031',
            'semester'=>'Genap',
            'tanggal_mulai'=>null,
            'tanggal_selesai'=>null,
            'status'=>'Non-Aktif',
        ]);
    }
}

<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PanduanSheet implements FromArray, WithTitle, ShouldAutoSize, WithStyles
{
    public function array(): array
    {
        return [
            ['Panduan Pengisian Data Import Mahasiswa'],
            [''],
            ['Kolom', 'Kewajiban', 'Format / Pilihan Pilihan', 'Keterangan'],
            ['nim', 'Wajib', 'Angka / Teks', 'Tanpa spasi, unik. Contoh: 10119001'],
            ['nama', 'Wajib', 'Teks', 'Nama lengkap mahasiswa'],
            ['email', 'Opsional', 'Email valid', 'Jika kosong default menggunakan nim@student.example.com'],
            ['prodi', 'Opsional', 'Teks', 'Contoh: Teknik Informatika'],
            ['kelas', 'Opsional', 'Pagi / Malam', 'Default: Pagi'],
            ['no_hp', 'Opsional', 'Angka / Teks', 'Contoh: 081234567890'],
            ['jenis_beasiswa', 'Opsional', 'Teks', 'Misal: KIP, Prestasi, Tidak Ada. Default: Tidak Ada'],
            ['jenis_kelamin', 'Opsional', 'Laki-Laki / Perempuan', 'Default: Laki-Laki'],
            ['angkatan', 'Wajib', 'Angka', 'Angka tahun, misal: 2021'],
            ['status', 'Opsional', 'Aktif / Cuti / Lulus', 'Default: Aktif'],
            ['alamat', 'Opsional', 'Teks', 'Alamat lengkap mahasiswa'],
            [''],
            ['Keterangan Tambahan:'],
            ['1. Pengisian data dimasukkan pada sheet "Data Mahasiswa".'],
            ['2. Pengisian dimulai pada baris ke-2 (di bawah baris heading/judul kolom).'],
            ['3. Baris yang tidak memiliki NIM atau Nama tidak akan diproses (diabaikan).'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:D1');
        
        return [
            1  => ['font' => ['bold' => true, 'size' => 14]],
            3  => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FFE0E0E0']]],
            16 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Panduan Pengisian';
    }
}

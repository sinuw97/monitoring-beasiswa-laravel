<?php

namespace App\Imports;

use App\Models\users\DetailMahasiswa;
use App\Models\users\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Exception;

class DataMahasiswaImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            // Validation or skip if empty
            if (!isset($row['nim']) || !isset($row['nama'])) {
                continue;
            }

            // Create/Update Mahasiswa (User Account)
            // Use updateOrCreate to avoid duplicates error, or just create if you want to fail on duplicate
            $mahasiswa = Mahasiswa::updateOrCreate(
                ['nim' => $row['nim']], // Search by NIM
                [
                    'name' => $row['nama'],
                    'email' => $row['email'] ?? $row['nim'] . '@student.example.com', // Fallback email
                    'password' => bcrypt($row['nim']), // Password = NIM
                    'avatar' => 'https://ui-avatars.com/api/?name=' . str_replace(' ', '+', $row['nama']),
                    'angkatan' => '20' . substr($row['nim'], 0, 2), // Assuming simple logic or provided
                ]
            );

            // Create/Update Detail Mahasiswa
            DetailMahasiswa::updateOrCreate(
                ['nim' => $row['nim']],
                [
                    'prodi' => $row['prodi'] ?? '-',
                    'kelas' => $row['kelas'] ?? 'Pagi',
                    'no_hp' => $row['no_hp'] ?? '-',
                    'jenis_beasiswa' => $row['jenis_beasiswa'] ?? 'Tidak Ada',
                    'jenis_kelamin' => $row['jenis_kelamin'] ?? 'Laki-Laki',
                    'angkatan' => '20' . substr($row['nim'], 0, 2),
                    'status' => $row['status'] ?? 'Aktif',
                    'alamat' => $row['alamat'] ?? '-',
                ]
            );
        }
    }
}

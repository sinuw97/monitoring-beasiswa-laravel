<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanUtamaSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithStyles
{
    protected $data;
    protected $rowNumber = 1;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function map($row): array
    {
        // Calculate Total Score on the fly
        $totalPoints = 0;
        // Check if relationships exist before summing, just in case
        if ($row->academicActivities) $totalPoints += $row->academicActivities->sum('points');
        if ($row->organizationActivities) $totalPoints += $row->organizationActivities->sum('points');
        if ($row->committeeActivities) $totalPoints += $row->committeeActivities->sum('points');
        if ($row->studentAchievements) $totalPoints += $row->studentAchievements->sum('points');
        if ($row->independentActivities) $totalPoints += $row->independentActivities->sum('points');

        return [
            $this->rowNumber++,
            $row->nim,
            $row->name,
            $row->prodi,             // Program Studi
            $row->angkatan,          // Angkatan
            $row->kelas,             // Kelas
            $row->jenis_beasiswa,    // Jenis Beasiswa
            $row->no_hp,             // No HP
            $row->email,             // Email
            $row->ips,               // IPS
            $row->ipk,               // IPK
            ucfirst($row->semester), // Semester Laporan (e.g., "Ganjil")
            $row->status,
            $totalPoints,
            '=HYPERLINK("' . url('/admin/laporan/' . $row->laporan_id) . '", "Lihat Detail")', // Link Detail
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'NIM',
            'Nama',
            'Prodi',
            'Angkatan',
            'Kelas',
            'Jenis Beasiswa',
            'No HP',
            'Email',
            'IPS',
            'IPK',
            'Semester Laporan',
            'Status',
            'Total Skor Laporan',
            'Link Detail',
        ];
    }

    public function title(): string
    {
        return 'Laporan Utama';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

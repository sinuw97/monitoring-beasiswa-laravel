<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanDataExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
        $totalPoints += $row->academicActivities->sum('points');
        $totalPoints += $row->organizationActivities->sum('points');
        $totalPoints += $row->committeeActivities->sum('points');
        $totalPoints += $row->studentAchievements->sum('points');
        $totalPoints += $row->independentActivities->sum('points');

        return [
            $this->rowNumber++,
            $row->nim,
            $row->name,
            ucfirst($row->semester), // Semester Laporan (e.g., "Ganjil")
            $row->status,
            $totalPoints,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'NIM',
            'Nama',
            'Semester Laporan',
            'Status',
            'Total Skor Laporan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
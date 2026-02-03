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
        return [
            $this->rowNumber++,
            $row->nim,
            $row->name,
            $row->prodi,             // Program Studi
            $row->angkatan,          // Angkatan
            ucfirst($row->semester), // Semester Laporan (e.g., "Ganjil")
            $row->created_at ? $row->created_at->format('Y-m-d') : '-', // Tanggal Laporan
            $row->ips,               // IPS
            $row->ipk,               // IPK
            $row->status,
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
            'Semester Laporan',
            'Tanggal Laporan',
            'IPS',
            'IPK',
            'Status',
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

<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TemplateDataSheet implements WithTitle, WithHeadings, ShouldAutoSize, WithStyles
{
    public function headings(): array
    {
        return [
            'nim',
            'nama',
            'email',
            'prodi',
            'kelas',
            'no_hp',
            'jenis_beasiswa',
            'jenis_kelamin',
            'angkatan',
            'status',
            'alamat',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Data Mahasiswa';
    }
}

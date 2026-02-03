<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class GenericMonevSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithStyles
{
    protected $title;
    protected $data;
    protected $modelClass;

    public function __construct(string $title, Collection $data, string $modelClass = null)
    {
        $this->title = $title;
        $this->data = $data;
        $this->modelClass = $modelClass;
    }

    public function collection()
    {
        return $this->data;
    }

    public function map($row): array
    {
        // Convert row to array
        $rowArray = $row->toArray();

        // Columns to exclude
        $excludedColumns = ['id', 'laporan_id', 'created_at', 'updated_at'];

        // Filter valid columns
        $filteredRow = array_diff_key($rowArray, array_flip($excludedColumns));

        // Reorder to ensure NIM is first if it exists
        $finalRow = [];

        // Add 'nim' first if it exists
        if (isset($filteredRow['nim'])) {
            $finalRow['nim'] = $filteredRow['nim'];
            unset($filteredRow['nim']);
        }

        // Add remaining columns
        $finalRow = array_merge($finalRow, $filteredRow);

        return $finalRow;
    }

    public function headings(): array
    {
        if ($this->data->isEmpty()) {
             if ($this->modelClass) {
                // Try to get columns from schema if data is empty but model is provided
                $table = (new $this->modelClass)->getTable();
                $columns = Schema::getColumnListing($table);

                // Exclude unwanted columns for headings too
                $excludedColumns = ['id', 'laporan_id', 'created_at', 'updated_at'];
                $filteredColumns = array_diff($columns, $excludedColumns);

                // Reorder 'nim' to front if present
                if (in_array('nim', $filteredColumns)) {
                    $filteredColumns = array_diff($filteredColumns, ['nim']);
                    array_unshift($filteredColumns, 'nim');
                }

                return $filteredColumns;
            }
            return [];
        }

        // Get keys from map logic using first item
        $firstItem = $this->data->first();
        return array_keys($this->map($firstItem));
    }

    public function title(): string
    {
        return $this->title;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

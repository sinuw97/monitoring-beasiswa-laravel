<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class GenericMonevSheet implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithStyles
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

    public function headings(): array
    {
        if ($this->data->isEmpty()) {
            if ($this->modelClass) {
                // Try to get columns from schema if data is empty but model is provided
                $table = (new $this->modelClass)->getTable();
                return Schema::getColumnListing($table);
            }
            return [];
        }

        // Get keys from the first item
        $firstItem = $this->data->first();
        if (is_array($firstItem)) {
            return array_keys($firstItem);
        }
        if (is_object($firstItem)) {
            return array_keys($firstItem->toArray());
        }

        return [];
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

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\TemplateDataSheet;
use App\Exports\Sheets\PanduanSheet;

class TemplateMahasiswaExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new TemplateDataSheet(),
            new PanduanSheet(),
        ];
    }
}

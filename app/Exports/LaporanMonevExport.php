<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\LaporanUtamaSheet;
use App\Exports\Sheets\GenericMonevSheet;
use App\Models\monev\AcademicReports;
use App\Models\monev\AcademicActivities;
use App\Models\monev\OrganizationActivities;
use App\Models\monev\CommitteeActivities;
use App\Models\monev\StudentAchievements;
use App\Models\monev\IndependentActivities;
use App\Models\monev\Evaluations;
use App\Models\monev\TargetNextSemester;
use App\Models\monev\TargetAcademicActivities;
use App\Models\monev\TargetAchievements;
use App\Models\monev\TargetIdependentActivities;

class LaporanMonevExport implements WithMultipleSheets
{
    protected $laporanData;

    public function __construct($laporanData)
    {
        $this->laporanData = $laporanData;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Sheet 1: Laporan Utama (Summary)
        $sheets[] = new LaporanUtamaSheet($this->laporanData);

        // Get array of IDs for filtering related tables
        $laporanIds = $this->laporanData->pluck('laporan_id')->toArray();

        // Helper to create generic sheets
        $createSheet = function($title, $modelClass) use ($laporanIds) {
            $data = $modelClass::whereIn('laporan_id', $laporanIds)->get();
            return new GenericMonevSheet($title, $data, $modelClass);
        };

        // Sheet 2: Laporan Akademik
        $sheets[] = $createSheet('Laporan Akademik', AcademicReports::class);

        // Sheet 3: Kegiatan Akademik
        $sheets[] = $createSheet('Kegiatan Akademik', AcademicActivities::class);

        // Sheet 4: Kegiatan Organisasi
        $sheets[] = $createSheet('Kegiatan Organisasi', OrganizationActivities::class);

        // Sheet 5: Kegiatan Kepanitiaan
        $sheets[] = $createSheet('Kegiatan Kepanitiaan', CommitteeActivities::class);

        // Sheet 6: Prestasi
        $sheets[] = $createSheet('Prestasi', StudentAchievements::class);

        // Sheet 7: Kegiatan Mandiri
        $sheets[] = $createSheet('Kegiatan Mandiri', IndependentActivities::class);

        // Sheet 8: Evaluasi
        $sheets[] = $createSheet('Evaluasi', Evaluations::class);

        // Sheet 9: Target Semester Depan
        $sheets[] = $createSheet('Target Semester Depan', TargetNextSemester::class);

        // Sheet 10: Target Akademik
        $sheets[] = $createSheet('Target Akademik', TargetAcademicActivities::class);

        // Sheet 11: Target Prestasi
        $sheets[] = $createSheet('Target Prestasi', TargetAchievements::class);

        // Sheet 12: Target Mandiri
        $sheets[] = $createSheet('Target Mandiri', TargetIdependentActivities::class);

        return $sheets;
    }
}

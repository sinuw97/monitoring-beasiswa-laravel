<?php

namespace App\Http\Controllers\admin\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\monev\AcademicActivities;
use App\Models\monev\AcademicReports;
use App\Models\monev\CommitteeActivities;
use App\Models\monev\Evaluations;
use App\Models\monev\IndependentActivities;
use App\Models\monev\KesanPesanMahasiswa;
use App\Models\monev\LaporanKeuanganMahasiswa;
use App\Models\monev\LaporanMonevMahasiswa;
use App\Models\monev\OrganizationActivities;
use App\Models\monev\StudentAchievements;
use App\Models\monev\TargetAcademicActivities;
use App\Models\monev\TargetAchievements;
use App\Models\monev\TargetNextSemester;
use App\Models\monev\TargetIdependentActivities;
use App\Models\semester\Periode;
use App\Models\users\Admin;
use App\Models\users\Mahasiswa;
use Illuminate\Support\Facades\Auth;

class LaporanMonevController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $dataAdmin = Admin::where('email', $admin->email)
            ->where('user_id', $admin->user_id)
            ->first();

        $dataAdmin->makeHidden(['password']);

        // Ambil periode aktif
        $periodeCheck1 = Periode::where('status', '=', 'Aktif')->get();
        $periodeCheck2 = Periode::where('status', '=', 'Aktif Sementara')->get();


        if ($periodeCheck1->count() > 0 || $periodeCheck2->count() > 0) {
            $periode = Periode::where('status', '=', 'Aktif')->orWhere('status', '=', 'Aktif Sementara')->first();

            $tahun = substr($periode->tahun_akademik, 0, 4);
            $semesterKode = $periode->semester == 'Ganjil' ? '01' : '02';
            $semesterId = 'SM' . $tahun . $semesterKode;

            // Ambil filter dan search dari request
            $angkatan = $request->angkatan;
            $status = $request->status;
            $periodeFilter = $request->periode;
            $search = $request->search;

            // Query dasar
            $query = LaporanMonevMahasiswa::join('mahasiswa', 'laporan_mahasiswa.nim', '=', 'mahasiswa.nim')
                ->join('detail_mahasiswa', 'mahasiswa.nim', '=', 'detail_mahasiswa.nim')
                ->where('semester_id', '=', $periodeFilter ?? $semesterId);

            // Filter angkatan
            if (!empty($angkatan)) {
                $query->where('detail_mahasiswa.angkatan', $angkatan);
            }

            // Filter status
            if (!empty($status)) {
                $query->where('laporan_mahasiswa.status', '=', $status);
            } else {
                $query->where('laporan_mahasiswa.status', '!=', 'Draft');
            }

            // Search by NIM or Nama
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('mahasiswa.nim', 'like', "%{$search}%")
                    ->orWhere('mahasiswa.name', 'like', "%{$search}%");
                });
            }

            // Sorting by Name
            if ($request->sort === 'asc') {
                $query->orderBy('mahasiswa.name', 'asc');
            } elseif ($request->sort === 'desc') {
                $query->orderBy('mahasiswa.name', 'desc');
            }

            // Ambil data dengan pagination
            $dataLaporan = $query->select('laporan_mahasiswa.*', 'mahasiswa.*')
                ->paginate(50)
                ->appends($request->query());

            // Ambil semua periode untuk filter dropdown
            $daftarPeriode = Periode::orderBy('tahun_akademik', 'desc')->get();

            // Ambil daftar angkatan
            $daftarAngkatan = \App\Models\users\DetailMahasiswa::select('angkatan')
            ->distinct()
            ->orderBy('angkatan', 'desc')
            ->get();
        }else{
            $dataLaporan = [];
            $periode = [];

            // Ambil semua periode untuk filter dropdown
            $daftarPeriode = Periode::orderBy('tahun_akademik', 'desc')->get();

            // Ambil daftar angkatan
            $daftarAngkatan = \App\Models\users\DetailMahasiswa::select('angkatan')
            ->distinct()
            ->orderBy('angkatan', 'desc')
            ->get();
        }

        return view('admin.laporan.index', [
            'dataAdmin' => $dataAdmin,
            'dataLaporan' => $dataLaporan,
            'periode' => $periode,
            'daftarPeriode' => $daftarPeriode,
            'daftarAngkatan' => $daftarAngkatan,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Export data to Excel.
     */
    public function export(Request $request)
    {
        // Ambil periode aktif
        $periodeCheck1 = Periode::where('status', '=', 'Aktif')->get();
        $periodeCheck2 = Periode::where('status', '=', 'Aktif Sementara')->get();

        $dataLaporan = [];

        if ($periodeCheck1->count() > 0 || $periodeCheck2->count() > 0) {
            $periode = Periode::where('status', '=', 'Aktif')->orWhere('status', '=', 'Aktif Sementara')->first();

            $tahun = substr($periode->tahun_akademik, 0, 4);
            $semesterKode = $periode->semester == 'Ganjil' ? '01' : '02';
            $semesterId = 'SM' . $tahun . $semesterKode;

            // Ambil filter dan search dari request
            $angkatan = $request->angkatan;
            $status = $request->status;
            $periodeFilter = $request->periode;
            $search = $request->search;

            // Query dasar
            $query = LaporanMonevMahasiswa::join('mahasiswa', 'laporan_mahasiswa.nim', '=', 'mahasiswa.nim')
                ->where('semester_id', '=', $periodeFilter ?? $semesterId);

            // Filter angkatan
            if (!empty($angkatan)) {
                $query->join('detail_mahasiswa', 'mahasiswa.nim', '=', 'detail_mahasiswa.nim')
                      ->where('detail_mahasiswa.angkatan', $angkatan);
            }

            // Filter status
            if (!empty($status)) {
                $query->where('laporan_mahasiswa.status', '=', $status);
            } else {
                $query->where('laporan_mahasiswa.status', '!=', 'Draft');
            }

            // Search by NIM or Nama
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('mahasiswa.nim', 'like', "%{$search}%")
                    ->orWhere('mahasiswa.name', 'like', "%{$search}%");
                });
            }

            // Sorting by Name
            if ($request->sort === 'asc') {
                $query->orderBy('mahasiswa.name', 'asc');
            } elseif ($request->sort === 'desc') {
                $query->orderBy('mahasiswa.name', 'desc');
            }

            // Ambil data (GET) bukan paginate
            $dataLaporan = $query->join('detail_mahasiswa', 'mahasiswa.nim', '=', 'detail_mahasiswa.nim')
                ->leftJoin('academic_reports', 'laporan_mahasiswa.laporan_id', '=', 'academic_reports.laporan_id')
                ->select(
                    'laporan_mahasiswa.*',
                    'mahasiswa.name',
                    'mahasiswa.email',
                    'detail_mahasiswa.prodi',
                    'detail_mahasiswa.angkatan',
                    'detail_mahasiswa.kelas',
                    'detail_mahasiswa.jenis_beasiswa',
                    'detail_mahasiswa.no_hp',
                    'detail_mahasiswa.alamat',
                    'academic_reports.ips',
                    'academic_reports.ipk'
                )
                ->get();

        }

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\LaporanMonevExport($dataLaporan), 'laporan_monev_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export multiple reports to PDF as ZIP.
     */
    public function exportPdfZip(Request $request)
    {
        // Ambil periode aktif
        $periodeCheck1 = Periode::where('status', '=', 'Aktif')->get();
        $periodeCheck2 = Periode::where('status', '=', 'Aktif Sementara')->get();

        if ($periodeCheck1->count() == 0 && $periodeCheck2->count() == 0) {
            return back()->with('error', 'Tidak ada periode aktif.');
        }

        $periode = Periode::where('status', '=', 'Aktif')->orWhere('status', '=', 'Aktif Sementara')->first();
        $tahun = substr($periode->tahun_akademik, 0, 4);
        $semesterKode = $periode->semester == 'Ganjil' ? '01' : '02';
        $semesterId = 'SM' . $tahun . $semesterKode;

        // Ambil filter dan search dari request
        $angkatan = $request->angkatan;
        $status = $request->status;
        $periodeFilter = $request->periode;
        $search = $request->search;

        // Query dasar dengan eager loading yang sama dengan exportPdf
        $query = LaporanMonevMahasiswa::with([
            'periodeSemester',
            'academicReports',
            'academicActivities',
            'committeeActivities',
            'organizationActivities',
            'studentAchievements',
            'independentActivities',
            'evaluations',
            'targetNextSemester',
        ])
        ->join('mahasiswa', 'laporan_mahasiswa.nim', '=', 'mahasiswa.nim') // Join untuk filter nama/nim
        ->where('semester_id', '=', $periodeFilter ?? $semesterId)
        ->select('laporan_mahasiswa.*'); // Pastikan hanya ambil kolom laporan agar tidak bentrok id

        // Filter angkatan
        if (!empty($angkatan)) {
            $query->join('detail_mahasiswa', 'mahasiswa.nim', '=', 'detail_mahasiswa.nim')
                  ->where('detail_mahasiswa.angkatan', $angkatan);
        }

        // Filter status
        if (!empty($status)) {
            $query->where('laporan_mahasiswa.status', '=', $status);
        } else {
            $query->where('laporan_mahasiswa.status', '!=', 'Draft');
        }

        // Search by NIM or Nama
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('mahasiswa.nim', 'like', "%{$search}%")
                ->orWhere('mahasiswa.name', 'like', "%{$search}%");
            });
        }

        // Sorting by Name
        if ($request->sort === 'asc') {
            $query->orderBy('mahasiswa.name', 'asc');
        } elseif ($request->sort === 'desc') {
            $query->orderBy('mahasiswa.name', 'desc');
        }

        $dataLaporan = $query->get();

        if ($dataLaporan->isEmpty()) {
            return back()->with('error', 'Tidak ada data laporan untuk diexport.');
        }

        // Buat file ZIP sementara
        $zipFileName = 'laporan_monev_' . date('Y-m-d_H-i-s') . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName); // Simpan sementara di storage

        // Pastikan direktori ada
        if (!file_exists(dirname($zipFilePath))) {
            mkdir(dirname($zipFilePath), 0755, true);
        }

        $zip = new \ZipArchive;
        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            foreach ($dataLaporan as $laporan) {
                $dataMahasiswa = Mahasiswa::where('nim', $laporan->nim)->first();

                if ($dataMahasiswa) {
                    // Fetch Cumulative Data
                    $allAchievements = \App\Models\monev\StudentAchievements::where('nim', $dataMahasiswa->nim)
                                        ->orderBy('start_date', 'asc')
                                        ->get();
                    $allOrganizations = \App\Models\monev\OrganizationActivities::where('nim', $dataMahasiswa->nim)
                                        ->orderBy('start_date', 'asc')
                                        ->get();
                    $allCommittees = \App\Models\monev\CommitteeActivities::where('nim', $dataMahasiswa->nim)
                                        ->orderBy('start_date', 'asc')
                                        ->get();
                    $allIndependent = \App\Models\monev\IndependentActivities::where('nim', $dataMahasiswa->nim)
                                        ->orderBy('start_date', 'asc')
                                        ->get();

                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.pdf_admin', compact(
                    'laporan',
                    'dataMahasiswa',
                    'allAchievements',
                    'allOrganizations',
                    'allCommittees',
                    'allIndependent'
                ));
                    $content = $pdf->output();

                    // Format nama file: [NIM]_[Semester]_[Tahun].pdf
                    // Ambil semester dan tahun dari relasi periodeSemester
                    $smt = $laporan->periodeSemester ? $laporan->periodeSemester->semester : 'Unit';
                    $thn = $laporan->periodeSemester ? $laporan->periodeSemester->tahun_akademik : 'Unknown';

                    // Bersihkan nama file dari karakter ilegal
                    $fileName = $dataMahasiswa->nim . '_' . $smt . '_' . $thn . '.pdf';
                    $fileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $fileName);

                    $zip->addFromString($fileName, $content);
                }
            }
            $zip->close();
        } else {
            return back()->with('error', 'Gagal membuat file ZIP.');
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    /**
     * Export single report to PDF.
     */
    public function exportPdf(string $id)
    {
        $laporan = LaporanMonevMahasiswa::with([
            'periodeSemester',
            'academicReports',
            'academicActivities',
            'committeeActivities',
            'organizationActivities',
            'studentAchievements',
            'independentActivities',
            'evaluations',
            'targetNextSemester',
            'targetAcademicActivities',
            'targetAchievements',
            'targetIndependentActivities',
            'laporanKeuanganMahasiswa.detailKeuanganMahasiswa',
            'kesanPesanMahasiswa'
        ])->where('laporan_id', $id)->firstOrFail();

        $dataMahasiswa = Mahasiswa::where('nim', $laporan->nim)->firstOrFail();

        // Fetch Cumulative Data
        $allAchievements = \App\Models\monev\StudentAchievements::where('nim', $dataMahasiswa->nim)
                            ->orderBy('start_date', 'asc')
                            ->get();
        $allOrganizations = \App\Models\monev\OrganizationActivities::where('nim', $dataMahasiswa->nim)
                            ->orderBy('start_date', 'asc')
                            ->get();
        $allCommittees = \App\Models\monev\CommitteeActivities::where('nim', $dataMahasiswa->nim)
                            ->orderBy('start_date', 'asc')
                            ->get();
        $allIndependent = \App\Models\monev\IndependentActivities::where('nim', $dataMahasiswa->nim)
                            ->orderBy('start_date', 'asc')
                            ->get();

        // Gunakan view yang detail untuk Admin
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.pdf_admin', compact(
            'laporan',
            'dataMahasiswa',
            'allAchievements',
            'allOrganizations',
            'allCommittees',
            'allIndependent'
        ));

        return $pdf->download('laporan_monev_' . $dataMahasiswa->nim . '_' . $laporan->periodeSemester?->semester . '.pdf');
    }

    /**
     * Export single report to Docx.
     */
    public function exportDocx(string $id)
    {
        $laporan = LaporanMonevMahasiswa::with([
            'academicActivities',
            'independentActivities', // Added independentActivities
            'evaluations', // Added evaluations
            'targetNextSemester', // Added targetNextSemester
            'targetAcademicActivities', // Added targetAcademicActivities
            'targetAchievements', // Added targetAchievements
            'targetIndependentActivities', // Added targetIndependentActivities
            'laporanKeuanganMahasiswa.detailKeuanganMahasiswa',
            'kesanPesanMahasiswa'
        ])
            ->where('laporan_id', $id)
            ->firstOrFail();

        $dataMahasiswa = Mahasiswa::where('nim', $laporan->nim)->firstOrFail();

        // Fetch Cumulative Data
        $allAchievements = \App\Models\monev\StudentAchievements::where('nim', $dataMahasiswa->nim)
                            ->orderBy('start_date', 'asc')
                            ->get();
        $allOrganizations = \App\Models\monev\OrganizationActivities::where('nim', $dataMahasiswa->nim)
                            ->orderBy('start_date', 'asc')
                            ->get();
        $allCommittees = \App\Models\monev\CommitteeActivities::where('nim', $dataMahasiswa->nim)
                            ->orderBy('start_date', 'asc')
                            ->get();
        $allIndependent = \App\Models\monev\IndependentActivities::where('nim', $dataMahasiswa->nim)
                            ->orderBy('start_date', 'asc')
                            ->get();

        $phpWord = $this->createPhpWordObject(
            $laporan,
            $dataMahasiswa,
            $allAchievements,
            $allOrganizations,
            $allCommittees,
            $allIndependent,
            $laporan->academicActivities,
            $laporan->independentActivities,
            $laporan->evaluations,
            $laporan->targetNextSemester,
            $laporan->targetAcademicActivities,
            $laporan->targetAchievements,
            $laporan->targetIndependentActivities
        );

         // Download
        $fileName = 'Laporan_Monev_' . $dataMahasiswa->nim . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'LaporanMonev');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    /**
     * Export multiple reports to Docx as ZIP.
     */
    public function exportDocxZip(Request $request)
    {
        // Ambil periode aktif
        $periodeCheck1 = Periode::where('status', '=', 'Aktif')->get();
        $periodeCheck2 = Periode::where('status', '=', 'Aktif Sementara')->get();

        if ($periodeCheck1->count() == 0 && $periodeCheck2->count() == 0) {
            return back()->with('error', 'Tidak ada periode aktif.');
        }

        $periode = Periode::where('status', '=', 'Aktif')->orWhere('status', '=', 'Aktif Sementara')->first();
        $tahun = substr($periode->tahun_akademik, 0, 4);
        $semesterKode = $periode->semester == 'Ganjil' ? '01' : '02';
        $semesterId = 'SM' . $tahun . $semesterKode;

        // Ambil filter dan search dari request
        $angkatan = $request->angkatan;
        $status = $request->status;
        $periodeFilter = $request->periode;
        $search = $request->search;

        // Query dasar dengan eager loading yang sama dengan exportDocx
        $query = LaporanMonevMahasiswa::with([
            'periodeSemester',
            'academicReports',
            'academicActivities', // Added academicActivities
            'laporanKeuanganMahasiswa.detailKeuanganMahasiswa',
            'kesanPesanMahasiswa'
        ])
        ->join('mahasiswa', 'laporan_mahasiswa.nim', '=', 'mahasiswa.nim') // Join untuk filter nama/nim
        ->where('semester_id', '=', $periodeFilter ?? $semesterId)
        ->select('laporan_mahasiswa.*'); // Pastikan hanya ambil kolom laporan agar tidak bentrok id

        // Filter angkatan
        if (!empty($angkatan)) {
            $query->join('detail_mahasiswa', 'mahasiswa.nim', '=', 'detail_mahasiswa.nim')
                  ->where('detail_mahasiswa.angkatan', $angkatan);
        }

        // Filter status
        if (!empty($status)) {
            $query->where('laporan_mahasiswa.status', '=', $status);
        } else {
            $query->where('laporan_mahasiswa.status', '!=', 'Draft');
        }

        // Search by NIM or Nama
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('mahasiswa.nim', 'like', "%{$search}%")
                ->orWhere('mahasiswa.name', 'like', "%{$search}%");
            });
        }

        // Sorting by Name
        if ($request->sort === 'asc') {
            $query->orderBy('mahasiswa.name', 'asc');
        } elseif ($request->sort === 'desc') {
            $query->orderBy('mahasiswa.name', 'desc');
        }

        $dataLaporan = $query->get();

        if ($dataLaporan->isEmpty()) {
            return back()->with('error', 'Tidak ada data laporan untuk diexport.');
        }

        // Buat file ZIP sementara
        $zipFileName = 'laporan_monev_docx_' . date('Y-m-d_H-i-s') . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName); // Simpan sementara di storage

        // Pastikan direktori ada
        if (!file_exists(dirname($zipFilePath))) {
            mkdir(dirname($zipFilePath), 0755, true);
        }

        $zip = new \ZipArchive;
        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            foreach ($dataLaporan as $laporan) {
                $dataMahasiswa = Mahasiswa::where('nim', $laporan->nim)->first();

                if ($dataMahasiswa) {
                    // Fetch Cumulative Data
                    $allAchievements = \App\Models\monev\StudentAchievements::where('nim', $dataMahasiswa->nim)
                                        ->orderBy('start_date', 'asc')
                                        ->get();
                    $allOrganizations = \App\Models\monev\OrganizationActivities::where('nim', $dataMahasiswa->nim)
                                        ->orderBy('start_date', 'asc')
                                        ->get();
                    $allCommittees = \App\Models\monev\CommitteeActivities::where('nim', $dataMahasiswa->nim)
                                        ->orderBy('start_date', 'asc')
                                        ->get();
                    $allIndependent = \App\Models\monev\IndependentActivities::where('nim', $dataMahasiswa->nim)
                                        ->orderBy('start_date', 'asc')
                                        ->get();

                    $phpWord = $this->createPhpWordObject(
                        $laporan,
                        $dataMahasiswa,
                        $allAchievements,
                        $allOrganizations,
                        $allCommittees,
                        $allIndependent,
                        $laporan->academicActivities,
                        $laporan->independentActivities,
                        $laporan->evaluations,
                        $laporan->targetNextSemester,
                        $laporan->targetAcademicActivities,
                        $laporan->targetAchievements,
                        $laporan->targetIndependentActivities
                    );

                    // Save individual docx to temp
                    $tempDocx = tempnam(sys_get_temp_dir(), 'LaporanMonevDocx');
                    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                    $objWriter->save($tempDocx);

                    // Format nama file: [NIM]_[Semester]_[Tahun].docx
                    $smt = $laporan->periodeSemester ? $laporan->periodeSemester->semester : 'Unit';
                    $thn = $laporan->periodeSemester ? $laporan->periodeSemester->tahun_akademik : 'Unknown';
                    $fileName = $dataMahasiswa->nim . '_' . $smt . '_' . $thn . '.docx';
                    $fileName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $fileName);

                    $zip->addFile($tempDocx, $fileName);

                    $tempFiles[] = $tempDocx;
                }
            }
            $zip->close();

            // Cleanup temp files
            if(isset($tempFiles)){
                foreach($tempFiles as $tf){
                    @unlink($tf);
                }
            }

        } else {
            return back()->with('error', 'Gagal membuat file ZIP.');
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    private function createPhpWordObject($laporan, $dataMahasiswa, $allAchievements, $allOrganizations, $allCommittees, $allIndependent, $academicActivities, $independentActivities, $evaluations, $targetNextSemester, $targetAcademicActivities, $targetAchievements, $targetIndependentActivities)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        $section = $phpWord->addSection();

        // Styles
        $headerStyle = ['bold' => true, 'size' => 14, 'name' => 'Arial'];
        $subHeaderStyle = ['bold' => true, 'size' => 11, 'name' => 'Arial'];
        $normalStyle = ['size' => 11, 'name' => 'Arial'];
        $boldStyle = ['bold' => true, 'size' => 11, 'name' => 'Arial'];
        $centerParam = ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER];
        $leftParam = ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START];
        $justifyParam = ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH];

        // --- COVER PAGE ---
        $section->addText("LAPORAN HASIL BELAJAR", $headerStyle, $centerParam);
        $section->addText("PENERIMA BANTUAN KIP KULIAH", $headerStyle, $centerParam);

        $section->addTextBreak(3);

        $logoPath = public_path('icon/Logo-TSU.png');
        if (file_exists($logoPath)) {
            $section->addImage($logoPath, [
                'width' => 200,
                'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
            ]);
        }
        $section->addTextBreak(3);

        $tableStyleName = 'CoverInfoTable';
        $tableStyle = [
            'borderSize' => 0,
            'borderColor' => 'FFFFFF',
            'cellMargin' => 50,
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
            'unit' => 'pct',
            'width' => 3500, // 70% of page width
        ];
        $phpWord->addTableStyle($tableStyleName, $tableStyle);
        $table = $section->addTable($tableStyleName);
        $table->addRow();
        $table->addCell(1500)->addText("NAMA", $normalStyle); // 30%
        $table->addCell(250)->addText(":", $normalStyle); // 5%
        $table->addCell(3250)->addText($dataMahasiswa->name, $normalStyle); // 65%
        $table->addRow();
        $table->addCell(1500)->addText("NIM", $normalStyle);
        $table->addCell(250)->addText(":", $normalStyle);
        $table->addCell(3250)->addText($dataMahasiswa->nim, $normalStyle);
        $table->addRow();
        $table->addCell(1500)->addText("ANGKATAN", $normalStyle);
        $table->addCell(250)->addText(":", $normalStyle);
        $table->addCell(3250)->addText($dataMahasiswa->detailMahasiswa->angkatan ?? '-', $normalStyle);
        $table->addRow();
        $table->addCell(1500)->addText("JENJANG/PROGRAM STUDI", $normalStyle);
        $table->addCell(250)->addText(":", $normalStyle);
        $table->addCell(3250)->addText("S1 / " . ($dataMahasiswa->detailMahasiswa->prodi ?? '-'), $normalStyle);



        $section->addTextBreak(5);
        $section->addText("Bantuan Biaya Pendidikan KIP KULIAH", $boldStyle, $centerParam);
        $section->addText("UNIVERSITAS TIGA SERANGKAI", $boldStyle, $centerParam);
        $section->addText("TAHUN " . date('Y'), $boldStyle, $centerParam);

        $section->addPageBreak();

        // --- SECTION I: DATA MAHASISWA ---
        $section->addText("I. DATA MAHASISWA", $subHeaderStyle);
        $table = $section->addTable(['borderSize' => 0]);
        $rows = [
            ['Nama', $dataMahasiswa->name],
            ['NIM', $dataMahasiswa->nim],
            ['Tempat, Tanggal Lahir', '-'], // Placeholder
            ['Program Studi', $dataMahasiswa->detailMahasiswa->prodi ?? '-'],
            ['Jenjang', 'S1'],
            ['Fakultas', '-'], // Placeholder
            ['Perguruan Tinggi', 'Universitas Tiga Serangkai'],
            ['Tahun Masuk', $dataMahasiswa->detailMahasiswa->angkatan ?? '-'],
            ['Tahun Lulus', '-'], // Placeholder
        ];
        foreach ($rows as $r) {
            $table->addRow();
            $table->addCell(3000)->addText($r[0], $normalStyle);
            $table->addCell(500)->addText(":", $normalStyle);
            $table->addCell(5000)->addText($r[1], $normalStyle);
        }
        $section->addTextBreak(1);

        // --- SECTION II: PRESTASI AKADEMIK ---
        // a) Hasil Studi
        $section->addText("II. LAPORAN PRESTASI AKADEMIK", $subHeaderStyle);
        $section->addText("a) Hasil Studi :", $normalStyle);

        // Cyan color for headers
        $headerColor = 'BFFBF9';
        $borderStyle = ['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50];
        $phpWord->addTableStyle('BorderedTable', $borderStyle);

        $table = $section->addTable('BorderedTable');
        $table->addRow();
        $table->addCell(1000, ['bgColor' => $headerColor])->addText("No.", $boldStyle, $centerParam);
        $table->addCell(4000, ['bgColor' => $headerColor])->addText("Semester", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("IPS", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("IPK", $boldStyle, $centerParam);

        // Fixed 8 semesters
        $allReports = AcademicReports::where('nim', $dataMahasiswa->nim)->get();
        for ($i = 1; $i <= 8; $i++) {
            $semNum = $i;
            $rep = $allReports->where('semester', $semNum)->first();

            // Roman numeral for semester
            $roman = match($semNum) {
                1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', default => $semNum
            };

            $table->addRow();
            $table->addCell(1000)->addText($i, $normalStyle, $centerParam);
            $table->addCell(4000)->addText($roman, $normalStyle, $centerParam); // Just Roman Numeral as per image
            $table->addCell(2000)->addText($rep ? $rep->ips : '', $normalStyle, $centerParam);
            $table->addCell(2000)->addText($rep ? $rep->ipk : '', $normalStyle, $centerParam);
        }

        $section->addText("*) Melampirkan KHS atau transkrip nilai keseluruhan sampai lulus yang dilegalisir oleh Jurusan/Program Studi", ['size' => 10, 'italic' => false], $leftParam);
        $section->addText("*) Untuk D3 maksimal semester 6, untuk D4/S1 maksimal semester 8", ['size' => 10, 'italic' => false], $leftParam);
        $section->addTextBreak(1);

        // b) Kegiatan Akademik Lain
        $section->addText("b) Kegiatan Akademik Lain :", $normalStyle);
        $table = $section->addTable('BorderedTable');
        $table->addRow();
        $table->addCell(1000, ['bgColor' => $headerColor])->addText("No.", $boldStyle, $centerParam);
        $table->addCell(3000, ['bgColor' => $headerColor])->addText("Kegiatan", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("Tipe", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("Keikutsertaan", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("Waktu", $boldStyle, $centerParam); // Tanggal/Waktu
        // Using academicActivities from relation
        $rowCount = max($academicActivities->count(), 2);
        for($i=0; $i<$rowCount; $i++) {
            $act = $academicActivities[$i] ?? null;
            $table->addRow();
            $table->addCell(1000)->addText($i+1, $normalStyle, $centerParam);
            $table->addCell(3000)->addText($act ? $act->activity_name : '', $normalStyle);
            $table->addCell(2000)->addText($act ? $act->activity_type : '', $normalStyle);
            $table->addCell(2000)->addText($act ? $act->participation : '', $normalStyle);
            $table->addCell(2000)->addText($act ? \Carbon\Carbon::parse($act->start_date)->format('d M Y') : '', $normalStyle);
        }
        $section->addText("*) melampirkan copy sertifikat/surat keterangan", ['size' => 10], $leftParam);
        $section->addTextBreak(1);

        // --- SECTION III: PRESTASI NON AKADEMIK ---
        $section->addText("III. LAPORAN PRESTASI NON AKADEMIK", $subHeaderStyle);

        // a) Prestasi
        $section->addText("a) Prestasi yang diraih selama menjadi mahasiswa Universitas Tiga Serangkai :", $normalStyle);
        $table = $section->addTable('BorderedTable');
        $table->addRow();
        $table->addCell(1000, ['bgColor' => $headerColor])->addText("No.", $boldStyle, $centerParam);
        $table->addCell(3000, ['bgColor' => $headerColor])->addText("Kegiatan", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("Tingkat", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("Waktu pelaksanaan", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("Hasil", $boldStyle, $centerParam);

        // Use Cumulative Data
        $rowCount = max($allAchievements->count(), 2);
        for($i=0; $i<$rowCount; $i++) {
            $act = $allAchievements[$i] ?? null;
            $table->addRow();
            $table->addCell(1000)->addText($i+1, $normalStyle, $centerParam);
            $table->addCell(3000)->addText($act ? $act->achievements_name : '', $normalStyle);
            $table->addCell(2000)->addText($act ? $act->level : '', $normalStyle);
            $table->addCell(2000)->addText($act ? $act->start_date : '', $normalStyle);
            $table->addCell(2000)->addText($act ? $act->award : '', $normalStyle);
        }

        $section->addText("*) Kolom 'Tingkat' diisi dengan pilihan kota/propinsi/nasional/internasional", ['size' => 10], $leftParam);
        $section->addText("*) melampirkan copy sertifikat/piagam", ['size' => 10], $leftParam);
        $section->addTextBreak(1);

        // b) Organisasi
        $section->addText("b) Keikutsertaan pada kegiatan organisasi kemahasiswaan intra kampus selama menjadi mahasiswa Universitas Tiga Serangkai :", $normalStyle);
        $table = $section->addTable('BorderedTable');
        $table->addRow();
        $table->addCell(1000, ['bgColor' => $headerColor])->addText("No.", $boldStyle, $centerParam);
        $table->addCell(3000, ['bgColor' => $headerColor])->addText("Nama Organisasi", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("Aktif sejak", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("Akhir Keaktifan", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("Jabatan", $boldStyle, $centerParam);

        // Use Cumulative Data
        $rowCount = max($allOrganizations->count(), 2);
        for($i=0; $i<$rowCount; $i++) {
            $act = $allOrganizations[$i] ?? null;
            $table->addRow();
            $table->addCell(1000)->addText($i+1, $normalStyle, $centerParam);
            $table->addCell(3000)->addText($act ? $act->ukm_name : '', $normalStyle);
            $table->addCell(2000)->addText($act ? $act->start_date : '', $normalStyle);
            $table->addCell(2000)->addText($act ? $act->end_date : '', $normalStyle);
            $table->addCell(2000)->addText($act ? $act->position : '', $normalStyle);
        }
        $section->addText("*) melampirkan copy sertifikat/surat keterangan dari pimpinan organisasi", ['size' => 10], $leftParam);
        $section->addTextBreak(1);

        // c) Kepanitiaan
        $section->addText("c) Keikutsertaan pada kegiatan kepanitiaan yang diikuti selama menjadi mahasiswa Universitas Tiga Serangkai :", $normalStyle);
        $table = $section->addTable('BorderedTable');
        $table->addRow();
        $table->addCell(1000, ['bgColor' => $headerColor])->addText("No.", $boldStyle, $centerParam);
        $table->addCell(5000, ['bgColor' => $headerColor])->addText("Kegiatan", $boldStyle, $centerParam);
        $table->addCell(3000, ['bgColor' => $headerColor])->addText("Waktu pelaksanaan", $boldStyle, $centerParam);

        // Use Cumulative Data
        $rowCount = max($allCommittees->count(), 2);
        for($i=0; $i<$rowCount; $i++) {
            $act = $allCommittees[$i] ?? null;
            $table->addRow();
            $table->addCell(1000)->addText($i+1, $normalStyle, $centerParam);
            $table->addCell(5000)->addText($act ? $act->activity_name : '', $normalStyle);
            $table->addCell(3000)->addText($act ? $act->start_date : '', $normalStyle);
        }
        $section->addText("*) melampirkan copy sertifikat/surat keterangan dari ketua panitia", ['size' => 10], $leftParam);
        $section->addTextBreak(1);

        // d) Kegiatan Mandiri (Using Report Data)
        $section->addText("d) Kegiatan Mandiri Mahasiswa :", $normalStyle);
        $table = $section->addTable('BorderedTable');
        $table->addRow();
        $table->addCell(1000, ['bgColor' => $headerColor])->addText("No.", $boldStyle, $centerParam);
        $table->addCell(4000, ['bgColor' => $headerColor])->addText("Kegiatan", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("Partisipasi", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("Waktu", $boldStyle, $centerParam);

        // Use Report Data
        $rowCount = max($independentActivities->count(), 2);
        for($i=0; $i<$rowCount; $i++) {
            $act = $independentActivities[$i] ?? null;
            $table->addRow();
            $table->addCell(1000)->addText($i+1, $normalStyle, $centerParam);
            $table->addCell(4000)->addText($act ? $act->activity_name : '', $normalStyle);
            $table->addCell(2000)->addText($act ? $act->participation : '', $normalStyle);
            $table->addCell(2000)->addText($act ? \Carbon\Carbon::parse($act->start_date)->format('d M Y') : '', $normalStyle);
        }
        $section->addText("*) melampirkan copy hasil Karya Ilmiah/Karya Tulis/PKM yang telah dibuat", ['size' => 10], $leftParam);
        $section->addTextBreak(1);

        // --- SECTION IV: EVALUASI (REALISASI) ---
        $section->addText("IV. EVALUASI (REALISASI)", $subHeaderStyle);

        $eval = $evaluations->first(); // Assuming single evaluation per report

        $section->addText("Faktor Pendukung :", $boldStyle);
        $section->addText($eval ? $eval->support_factors : '-', $normalStyle);
        $section->addTextBreak(1);

        $section->addText("Faktor Penghambat :", $boldStyle);
        $section->addText($eval ? $eval->barrier_factors : '-', $normalStyle);
        $section->addTextBreak(1);

         // --- SECTION V: TARGET SEMESTER DEPAN (Rencana) ---
        $section->addText("V. TARGET SEMESTER DEPAN (Rencana)", $subHeaderStyle);

        // a) Rencana Nilai IPS dan IPK
        $section->addText("a) Rencana Nilai IPS dan IPK :", $normalStyle);
        $table = $section->addTable('BorderedTable');
        $table->addRow();
        $table->addCell(1000, ['bgColor' => $headerColor])->addText("No.", $boldStyle, $centerParam);
        $table->addCell(3000, ['bgColor' => $headerColor])->addText("Semester", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("Target IPS", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("Target IPK", $boldStyle, $centerParam);

        $rowCount = max($targetNextSemester->count(), 2);
        for($i=0; $i<$rowCount; $i++) {
            $item = $targetNextSemester[$i] ?? null;
            $table->addRow();
            $table->addCell(1000)->addText($i+1, $normalStyle, $centerParam);
            $table->addCell(3000)->addText($item ? $item->semester : '', $normalStyle, $centerParam);
            $table->addCell(2000)->addText($item ? $item->target_ips : '', $normalStyle, $centerParam);
            $table->addCell(2000)->addText($item ? $item->target_ipk : '', $normalStyle, $centerParam);
        }
        $section->addTextBreak(1);

        // b) Rencana Kegiatan Akademik
        $section->addText("b) Rencana Kegiatan Akademik :", $normalStyle);
        $table = $section->addTable('BorderedTable');
        $table->addRow();
        $table->addCell(1000, ['bgColor' => $headerColor])->addText("No.", $boldStyle, $centerParam);
        $table->addCell(4000, ['bgColor' => $headerColor])->addText("Kegiatan", $boldStyle, $centerParam);
        $table->addCell(4000, ['bgColor' => $headerColor])->addText("Rencana/Strategi", $boldStyle, $centerParam);

        $rowCount = max($targetAcademicActivities->count(), 2);
        for($i=0; $i<$rowCount; $i++) {
            $item = $targetAcademicActivities[$i] ?? null;
            $table->addRow();
            $table->addCell(1000)->addText($i+1, $normalStyle, $centerParam);
            $table->addCell(4000)->addText($item ? $item->activity_name : '', $normalStyle);
            $table->addCell(4000)->addText($item ? $item->strategy : '', $normalStyle);
        }
        $section->addTextBreak(1);

        // c) Rencana Prestasi
        $section->addText("c) Rencana Prestasi Mahasiswa :", $normalStyle);
        $table = $section->addTable('BorderedTable');
        $table->addRow();
        $table->addCell(1000, ['bgColor' => $headerColor])->addText("No.", $boldStyle, $centerParam);
        $table->addCell(3000, ['bgColor' => $headerColor])->addText("Prestasi", $boldStyle, $centerParam);
        $table->addCell(3000, ['bgColor' => $headerColor])->addText("Tingkat/Raihan", $boldStyle, $centerParam);

        $rowCount = max($targetAchievements->count(), 2);
        for($i=0; $i<$rowCount; $i++) {
            $item = $targetAchievements[$i] ?? null;
            $table->addRow();
            $table->addCell(1000)->addText($i+1, $normalStyle, $centerParam);
            $table->addCell(3000)->addText($item ? $item->achievements_name : '', $normalStyle);
            $table->addCell(3000)->addText($item ? ($item->level . ' / ' . $item->award) : '', $normalStyle);
        }
        $section->addTextBreak(1);

        // d) Rencana Kegiatan Mandiri
        $section->addText("d) Rencana Kegiatan Mandiri :", $normalStyle);
        $table = $section->addTable('BorderedTable');
        $table->addRow();
        $table->addCell(1000, ['bgColor' => $headerColor])->addText("No.", $boldStyle, $centerParam);
        $table->addCell(3000, ['bgColor' => $headerColor])->addText("Kegiatan", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("Partisipasi", $boldStyle, $centerParam);
        $table->addCell(3000, ['bgColor' => $headerColor])->addText("Rencana/Strategi", $boldStyle, $centerParam);

        $rowCount = max($targetIndependentActivities->count(), 2);
        for($i=0; $i<$rowCount; $i++) {
            $item = $targetIndependentActivities[$i] ?? null;
            $table->addRow();
            $table->addCell(1000)->addText($i+1, $normalStyle, $centerParam);
            $table->addCell(3000)->addText($item ? $item->activity_name : '', $normalStyle);
            $table->addCell(2000)->addText($item ? $item->participation : '', $normalStyle);
            $table->addCell(3000)->addText($item ? $item->strategy : '', $normalStyle);
        }
        $section->addTextBreak(1);

        // --- SECTION VI: LAPORAN KEUANGAN ---
        $section->addText("VI. LAPORAN KEUANGAN", $subHeaderStyle);
        $section->addText("Laporan rata-rata pemakaian dana biaya hidup yang diberikan sebesar Rp 5.700.000,- per semester oleh mahasiswa selama satu semester :", $normalStyle, $justifyParam);
        $section->addTextBreak(1);

        $table = $section->addTable('BorderedTable');
        $table->addRow();
        $table->addCell(1000, ['bgColor' => $headerColor])->addText("No", $boldStyle, $centerParam);
        $table->addCell(5000, ['bgColor' => $headerColor])->addText("Keperluan", $boldStyle, $centerParam);
        $table->addCell(3000, ['bgColor' => $headerColor])->addText("Nominal", $boldStyle, $centerParam);

        // Fixed rows as per image/template implication, but filling with available data?
        // Since the data is dynamic, I will list the dynamic data, but try to map them if they match.
        // For now, I will just list the user data.
        $total = 0;
        $keuanganItems = $laporan->laporanKeuanganMahasiswa ? $laporan->laporanKeuanganMahasiswa->detailKeuanganMahasiswa : collect([]);

        if ($keuanganItems->isNotEmpty()) {
            foreach ($keuanganItems as $idx => $keuangan) {
                 $table->addRow();
                 $table->addCell(1000)->addText($idx + 1, $normalStyle, $centerParam);
                 $table->addCell(5000)->addText($keuangan->keperluan, $normalStyle); // Changed from description
                 $table->addCell(3000)->addText("Rp " . number_format($keuangan->nominal, 0, ',', '.'), $normalStyle); // Changed from amount
                 $total += $keuangan->nominal; // Changed from amount
            }
        } else {
             // Blank rows if no data
             for($k=1; $k<=5; $k++) {
                 $table->addRow();
                 $table->addCell(1000)->addText($k, $normalStyle, $centerParam);
                 $table->addCell(5000)->addText("", $normalStyle);
                 $table->addCell(3000)->addText("", $normalStyle);
             }
        }

        // Total Row
        $table->addRow();
        $table->addCell(6000, ['gridSpan' => 2])->addText("Jumlah", $boldStyle, $centerParam);
        $table->addCell(3000)->addText("Rp " . number_format($total, 0, ',', '.'), $boldStyle);

        $section->addTextBreak(1);

        // --- SECTION V: KESAN PESAN ---
        $section->addText("VII. Kesan - pesan Mahasiswa", $subHeaderStyle);
        $section->addText("Diisi kesan selama menerima beasiswa KIPdi Universitas Tiga Serangkai", ['italic' => true, 'color' => '0099CC', 'size'=>10]);
        $section->addText("__________________________________________________________________________________", $normalStyle);

        $kesan = $laporan->kesanPesanMahasiswa->first() ? $laporan->kesanPesanMahasiswa->first()->kesan : ''; // Access first item
        $pesan = $laporan->kesanPesanMahasiswa->first() ? $laporan->kesanPesanMahasiswa->first()->pesan : ''; // Access first item
        if($kesan || $pesan) {
            $section->addText($kesan . " " . $pesan, $normalStyle);
        } else {
            $section->addTextBreak(2);
        }
        $section->addTextBreak(1);
        $section->addText("Demikian laporan ini saya buat dengan sebenar-benarnya.", $normalStyle);

         // --- SIGNATURES ---
        $section->addTextBreak(2);

        // Signature Table
        $table = $section->addTable(['borderSize' => 0, 'width' => 100 * 50]);
        $table->addRow();

        // Left Column: Wakil Rektor
        $cell1 = $table->addCell(5000);
        $cell1->addText("Mengetahui,", $normalStyle);
        $cell1->addText("Wakil Rektor", $normalStyle);
        $cell1->addText("Bidang Akademik, Inovasi dan Kemahasiswaan", $normalStyle);
        $cell1->addTextBreak(4);
        $cell1->addText("Prof. Dr. Drajat Tri Kartono, M.Si", $boldStyle);
        $cell1->addText("NIP. 102024039", $normalStyle);

        // Right Column: Student
        $cell2 = $table->addCell(4000);
        $cell2->addText("", $normalStyle); // Spacing
        // City and Date
        $cell2->addText("Surakarta, " . date('d F Y'), $normalStyle);
        $cell2->addText("Pembuat Laporan", $normalStyle);
        $cell2->addTextBreak(1);
        $cell2->addText("METERAI", ['size' => 8], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $cell2->addText("Rp 10.000,-", ['size' => 8], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $cell2->addTextBreak(1);
        $cell2->addText($dataMahasiswa->name, $boldStyle);
        $cell2->addText("NIM. " . $dataMahasiswa->nim, $normalStyle);

        // --- LAMPIRAN ---
        $section->addPageBreak();
        $section->addText("Lampiran - lampiran", ['bold' => true, 'size' => 12], $centerParam);
        $section->addTextBreak(1);

        $table = $section->addTable('BorderedTable');
        $table->addRow();
        $table->addCell(1000, ['bgColor' => $headerColor])->addText("No.", $boldStyle, $centerParam);
        $table->addCell(6000, ['bgColor' => $headerColor])->addText("Nama Dokumen", $boldStyle, $centerParam);
        $table->addCell(2000, ['bgColor' => $headerColor])->addText("Status", $boldStyle, $centerParam);

        $lampiranItems = [
            "Kartu Hasil Studi (KHS)",
            "Surat Keterangan Aktif Kuliah",
            "Copy sertifikat/piagam prestasi yang diraih selama menjadi mahasiswa",
            "Copy sertifikat/surat keterangan keikutsertaan pada kegiatan organisasi kemahasiswaan intra kampus",
            "Copy sertifikat/surat keterangan keikutsertaan pada kegiatan kepanitiaan",
            "Copy hasil publikasi Ilmiah/Karya Tulis/PKM",
            "Copy Surat Keterangan Lulus/ Copy Ijazah",
            "Copy Transkrip Nilai",
            "......................... (Lampiran lain)",
            "Dst."
        ];

        foreach ($lampiranItems as $idx => $item) {
             $table->addRow();
             if ($item === "Dst.") {
                 $table->addCell(1000)->addText($item, $normalStyle, $centerParam); // Dst. in No column
                 $table->addCell(6000)->addText("", $normalStyle);
                 $table->addCell(2000)->addText("", $normalStyle);
             } else {
                 $table->addCell(1000)->addText($idx + 1, $normalStyle, $centerParam);
                 $table->addCell(6000)->addText($item, $normalStyle);
                 $table->addCell(2000)->addText($idx < 8 ? "Ada / Tidak" : "", $normalStyle, $centerParam);
             }
        }

        return $phpWord;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // ambil data monev mhs
        $admin = Auth::guard('admin')->user();

        $dataAdmin = Admin::where('email', $admin->email)
            ->where('user_id', $admin->user_id)
            ->first();

        $dataAdmin->makeHidden(['password']);

        $laporan = LaporanMonevMahasiswa::where('laporan_id', $id)->first();

        $academicReports = AcademicReports::where('laporan_id', $id)->get();
        $academicActivities = AcademicActivities::where('laporan_id', $id)->get();
        $organizationActivities = OrganizationActivities::where('laporan_id', $id)->get();
        $committeeActivities = CommitteeActivities::where('laporan_id', $id)->get();
        $studentAchievements = StudentAchievements::where('laporan_id', $id)->get();
        $independentActivities = IndependentActivities::where('laporan_id', $id)->get();
        $evaluations = Evaluations::where('laporan_id', $id)->get();
        $targetNextSemester = TargetNextSemester::where('laporan_id', $id)->get();
        $targetAcademicActivities = TargetAcademicActivities::where('laporan_id', $id)->get();
        $targetAchievements = TargetAchievements::where('laporan_id', $id)->get();
        $targetachievements = TargetAchievements::where('laporan_id', $id)->get();
        $targetIdependentActivities = TargetIdependentActivities::where('laporan_id', $id)->get();

        $laporanKeuangan = LaporanKeuanganMahasiswa::with('detailKeuanganMahasiswa')->where('laporan_id', $id)->first();
        $kesanPesan = KesanPesanMahasiswa::where('laporan_id', $id)->get();

        if (!$laporan) {
            return back()->with('error', 'Laporan tidak ditemukan.');
        }

        $dataMahasiswa = Mahasiswa::where('nim', '=', $laporan->nim)->first();

        $totalPoints = 0;

        // Gunakan metode 'sum' pada koleksi Eloquent untuk menghitung total points
        // Jika kolom 'points' belum ada di database, ini akan mengembalikan 0.
        $totalPoints += $academicActivities->sum('points');
        $totalPoints += $organizationActivities->sum('points');
        $totalPoints += $committeeActivities->sum('points');
        $totalPoints += $studentAchievements->sum('points');
        $totalPoints += $independentActivities->sum('points');

        // return dd($parsingAcademicReports);

        return view('admin.laporan.show', compact(
            'dataAdmin',
            'dataMahasiswa',
            'laporan',
            'academicReports',
            'academicActivities',
            'organizationActivities',
            'committeeActivities',
            'studentAchievements',
            'independentActivities',
            'evaluations',
            'targetNextSemester',
            'targetAcademicActivities',
            'targetAchievements',
            'targetIdependentActivities',
            'laporanKeuangan',
            'kesanPesan',
            'totalPoints',
        ));
    }

    public function academicReports(Request $request, string $id, string $idAcademicReports){

        $academicReports = AcademicReports::where('laporan_id', $id)->where('id', $idAcademicReports)->first();

        $request->validate([
            $request->status => 'string|max:8',
            $request->comment => 'string|max:255'
        ]);

        if($request->status && $request->comment){
            $academicReports->update([
                'status' => $request->status,
                'comment' => $request->comment,
            ]);
        }else if(!$request->status && $request->comment){
            $academicReports->update([
                'comment' => $request->comment,
            ]);
        }else{
            $academicReports->update([
                'status' => $request->status,
            ]);
        }


        return redirect('/admin/laporan/'.$id)->with('success', 'IPK/IPS berhasil diubah.');
    }
    public function adacademicActivities(Request $request, string $id, string $idAcademicActivities){

        $academicActivities = AcademicActivities::where('laporan_id', $id)->where('id', $idAcademicActivities)->first();

        $request->validate([
            $request->status => 'string|max:8',
            $request->comment => 'string|max:255'
        ]);

        if($request->status && $request->comment){
            $academicActivities->update([
                'status' => $request->status,
                'comment' => $request->comment,
            ]);
        }else if(!$request->status && $request->comment){
            $academicActivities->update([
                'comment' => $request->comment,
            ]);
        }else{
            $academicActivities->update([
                'status' => $request->status,
            ]);
        }

        return redirect('/admin/laporan/'.$id)->with('success', 'Kegiatan akademik berhasil diubah.');
    }
    public function organizationActivities(Request $request, string $id, string $idOrganizationActivities){

        $organizationActivities = OrganizationActivities::where('laporan_id', $id)->where('id', $idOrganizationActivities)->first();

        $request->validate([
            $request->status => 'string|max:8',
            $request->comment => 'string|max:255'
        ]);

        if($request->status && $request->comment){
            $organizationActivities->update([
                'status' => $request->status,
                'comment' => $request->comment,
            ]);
        }else if(!$request->status && $request->comment){
            $organizationActivities->update([
                'comment' => $request->comment,
            ]);
        }else{
            $organizationActivities->update([
                'status' => $request->status,
            ]);
        }

        return redirect('/admin/laporan/'.$id)->with('success', 'Kegiatan organisasi berhasil diubah.');
    }
    public function committeeActivities(Request $request, string $id, string $idCommitteeActivities){

        $committeeActivities = CommitteeActivities::where('laporan_id', $id)->where('id', $idCommitteeActivities)->first();

        $request->validate([
            $request->status => 'string|max:8',
            $request->comment => 'string|max:255'
        ]);

        if($request->status && $request->comment){
            $committeeActivities->update([
                'status' => $request->status,
                'comment' => $request->comment,
            ]);
        }else if(!$request->status && $request->comment){
            $committeeActivities->update([
                'comment' => $request->comment,
            ]);
        }else{
            $committeeActivities->update([
                'status' => $request->status,
            ]);
        }

        return redirect('/admin/laporan/'.$id)->with('success', 'Kegiatan kepanitiaan berhasil diubah.');
    }
    public function studentAchievements(Request $request, string $id, string $idStudentAchievements){

        $studentAchievements = studentAchievements::where('laporan_id', $id)->where('id', $idStudentAchievements)->first();

        $request->validate([
            $request->status => 'string|max:8',
            $request->comment => 'string|max:255'
        ]);

        if($request->status && $request->comment){
            $studentAchievements->update([
                'status' => $request->status,
                'comment' => $request->comment,
            ]);
        }else if(!$request->status && $request->comment){
            $studentAchievements->update([
                'comment' => $request->comment,
            ]);
        }else{
            $studentAchievements->update([
                'status' => $request->status,
            ]);
        }

        return redirect('/admin/laporan/'.$id)->with('success', 'Prestasi mahasiswa berhasil diubah.');
    }
    public function independentActivities(Request $request, string $id, string $idIndependentActivities){

        $independentActivities = IndependentActivities::where('laporan_id', $id)->where('id', $idIndependentActivities)->first();

        $request->validate([
            $request->status => 'string|max:8',
            $request->comment => 'string|max:255'
        ]);

        if($request->status && $request->comment){
            $independentActivities->update([
                'status' => $request->status,
                'comment' => $request->comment,
            ]);
        }else if(!$request->status && $request->comment){
            $independentActivities->update([
                'comment' => $request->comment,
            ]);
        }else{
            $independentActivities->update([
                'status' => $request->status,
            ]);
        }

        return redirect('/admin/laporan/'.$id)->with('success', 'Aktivitas independen berhasil diubah.');
    }
    public function evaluations(Request $request, string $id, string $idEvaluations){

        $evaluations = Evaluations::where('laporan_id', $id)->where('id', $idEvaluations)->first();

        $request->validate([
            $request->status => 'string|max:8',
            $request->comment => 'string|max:255'
        ]);

        if($request->status){
            $evaluations->update([
                'status' => $request->status,
            ]);
        }

        return redirect('/admin/laporan/'.$id)->with('success', 'Evaluasi berhasil diubah.');
    }

    public function laporanKeuangan(Request $request, string $id, string $idKeuangan){
        // Note: idKeuangan here refers to the detail item ID (DetailKeuanganMahasiswa), not the parent LaporanKeuanganMahasiswa
        $detailKeuangan = \App\Models\monev\DetailKeuanganMahasiswa::find($idKeuangan);

        if (!$detailKeuangan) {
             return redirect('/admin/laporan/'.$id)->with('error', 'Data keuangan tidak ditemukan.');
        }

        // Validate request if needed, though usually just status for admin
        // $request->validate([...]);

        if($request->status){
            $detailKeuangan->update([
                'status' => $request->status,
                // 'comment' => $request->comment, // If table support comment
            ]);
        }
         return redirect('/admin/laporan/'.$id)->with('success', 'Status keuangan berhasil diubah.');
    }

    public function kesanPesan(Request $request, string $id, string $idKesanPesan){

        $kesanPesan = KesanPesanMahasiswa::find($idKesanPesan);

        if (!$kesanPesan) {
             return redirect('/admin/laporan/'.$id)->with('error', 'Data kesan pesan tidak ditemukan.');
        }

        if($request->status){
            $kesanPesan->update([
                'status' => $request->status,
            ]);
        }
        return redirect('/admin/laporan/'.$id)->with('success', 'Status kesan pesan berhasil diubah.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $admin = Auth::guard('admin')->user();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $admin = Auth::guard('admin')->user();

        $dataLaporan = LaporanMonevMahasiswa::where('laporan_id', $id)->first();

        $dataLaporan->update([
            'status' => $request->status,
        ]);

        return redirect('/admin/laporan/'.$id)->with('success', 'Status laporan berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

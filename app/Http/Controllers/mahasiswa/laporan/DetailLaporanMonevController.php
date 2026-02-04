<?php

namespace App\Http\Controllers\mahasiswa\laporan;

use App\Http\Controllers\Controller;
use App\Models\mahasiswa\PengisianMonev\NilaiIPSnIPK;
use App\Models\monev\AcademicReports;
use App\Models\monev\LaporanMonevMahasiswa;
use Illuminate\Support\Facades\Auth;

class DetailLaporanMonevController extends Controller
{
    // Untuk nampilin halaman Detail
    public function showHalamanDetailLaporan(string $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

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
        ])
            ->where('laporan_id', $laporanId)
            ->where('nim', $dataMahasiswa->nim)
            ->first();

        if (!$laporan) {
            return back()->with('error', 'Laporan tidak ditemukan.');
        }

        // parsing setiap model
        $parsingAcademicReports = $laporan->academicReports->map(function ($report, $i) {
            return [
                'id' => $report->id,
                'semester' => $report->semester,
                'ips' => $report->ips,
                'ipk' => $report->ipk,
                'bukti' => $report->bukti_url, //Sementara
                'komentar' => $report->comment,
                'status' => $report->status,
            ];
        });
        $parsingAcademicActivities = $laporan->academicActivities->map(function ($report, $i) {
            return [
                'id' => $report->id,
                'activity-name' => $report->activity_name,
                'activity-type' => $report->activity_type,
                'participation' => $report->participation,
                'place' => $report->place,
                'start-date' => $report->start_date,
                'end-date' => $report->end_date,
                'bukti' => $report->bukti_url, //Sementara
                'point' => $report->points,
                'komentar' => $report->comment,
                'status' => $report->status,
            ];
        });
        $parsingOrganizationActivities = $laporan->organizationActivities->map(function ($report, $i) {
            return [
                'id' => $report->id,
                'ukm-name' => $report->ukm_name,
                'activity-name' => $report->activity_name,
                'level' => $report->level,
                'position' => $report->position,
                'place' => $report->place,
                'start-date' => $report->start_date,
                'end-date' => $report->end_date,
                'bukti' => $report->bukti_url, //Sementara
                'point' => $report->points,
                'komentar' => $report->comment,
                'status' => $report->status,
            ];
        });
        $parsingCommitteeActivities = $laporan->committeeActivities->map(function ($report, $i) {
            return [
                'id' => $report->id,
                'activity-name' => $report->activity_name,
                'activity-type' => $report->activity_type,
                'participation' => $report->participation,
                'level' => $report->level,
                'place' => $report->place,
                'start-date' => $report->start_date,
                'end-date' => $report->end_date,
                'bukti' => $report->bukti_url, //Sementara
                'point' => $report->points,
                'komentar' => $report->comment,
                'status' => $report->status,
            ];
        });
        $parsingAchievements = $laporan->studentAchievements->map(function ($report, $i) {
            return [
                'id' => $report->id,
                'achievements-name' => $report->achievements_name,
                'achievements-type' => $report->achievements_type,
                'level' => $report->level,
                'award' => $report->award,
                'place' => $report->place,
                'start-date' => $report->start_date,
                'end-date' => $report->end_date,
                'bukti' => $report->bukti_url, //Sementara
                'point' => $report->points,
                'komentar' => $report->comment,
                'status' => $report->status,
            ];
        });
        $parsingIndependentActivities = $laporan->independentActivities->map(function ($report, $i) {
            return [
                'id' => $report->id,
                'activity-name' => $report->activity_name,
                'activity-type' => $report->activity_type,
                'participation' => $report->participation,
                'place' => $report->place,
                'start-date' => $report->start_date,
                'end-date' => $report->end_date,
                'bukti' => $report->bukti_url, //Sementara
                'point' => $report->points,
                'komentar' => $report->comment,
                'status' => $report->status,
            ];
        });
        $parsingEvaluations = $laporan->evaluations->first();
        $parsingNextReports = $laporan->targetNextSemester->map(function ($report, $i) {
            return [
                'id' => $report->id,
                'semester' => $report->semester,
                'target-ips' => $report->target_ips,
                'target-ipk' => $report->target_ipk,
                'status' => $report->status,
            ];
        });
        $parsingNextAcademicActivities = $laporan->targetAcademicActivities->map(function ($report, $i) {
            return [
                'id' => $report->id,
                'activity-name' => $report->activity_name,
                'strategy' => $report->strategy,
                'status' => $report->status,
            ];
        });
        $parsingNextAchievements = $laporan->targetAchievements->map(function ($report, $i) {
            return [
                'id' => $report->id,
                'achievements-name' => $report->achievements_name,
                'level' => $report->level,
                'award' => $report->award,
                'status' => $report->status,
            ];
        });
        $parsingNextIndependentActivities = $laporan->targetIndependentActivities->map(function ($report, $i) {
            return [
                'id' => $report->id,
                'activity-name' => $report->activity_name,
                'participation' => $report->participation,
                'strategy' => $report->strategy,
                'status' => $report->status,
            ];
        });
        $laporanKeuangan = $laporan->laporanKeuanganMahasiswa;

        $parsingLaporanKeuangan = null;

        if ($laporanKeuangan) {
            $parsingLaporanKeuangan = [
                'id' => $laporanKeuangan->id,
                'total' => $laporanKeuangan->total_nominal,
                'status' => $laporanKeuangan->status,
                'detail' => $laporanKeuangan->detailKeuanganMahasiswa->map(function ($detail) {
                    return [
                        'id' => $detail->id,
                        'keperluan' => $detail->keperluan,
                        'nominal' => $detail->nominal,
                        'status' => $detail->status,
                    ];
                }),
            ];
        }

        $parsingKesanPesan = $laporan->kesanPesanMahasiswa->map(function ($report) {
            return [
                'id' => $report->id,
                'kesan' => $report->kesan,
                'pesan' => $report->pesan,
                'status' => $report->status,
            ];
        });

        return view('mahasiswa.detail-laporan', compact([
            'dataMahasiswa',
            'laporan',
            'parsingAcademicReports',
            'parsingAcademicActivities',
            'parsingOrganizationActivities',
            'parsingCommitteeActivities',
            'parsingAchievements',
            'parsingIndependentActivities',
            'parsingEvaluations',
            'parsingNextReports',
            'parsingNextAcademicActivities',
            'parsingNextAchievements',
            'parsingNextIndependentActivities',
            'parsingLaporanKeuangan',
            'parsingKesanPesan'
        ]));
    }
    public function exportDocx(string $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        $laporan = LaporanMonevMahasiswa::with([
            'periodeSemester',
            'academicReports',
            // Relations below kept for other uses if needed, but we will fetch all specifically
            'laporanKeuanganMahasiswa.detailKeuanganMahasiswa',
            'kesanPesanMahasiswa'
        ])
            ->where('laporan_id', $laporanId)
            ->where('nim', $dataMahasiswa->nim)
            ->firstOrFail();

        if (!in_array(strtolower($laporan->status), ['lolos', 'approved'])) {
            return back()->with('error', 'Laporan belum disetujui, tidak dapat mengunduh dokumen.');
        }

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
        $section->addTextBreak(4);

        $logoPath = public_path('icon/Logo-TSU.png');
        if (file_exists($logoPath)) {
            $section->addImage($logoPath, [
                'width' => 200,
                'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
            ]);
        }
        $section->addTextBreak(4);

        $tableStyle = ['borderSize' => 0, 'borderColor' => 'FFFFFF', 'cellMargin' => 50];
        // Center the table visually by using a fixed width table centered in page?
        // Or just indent. Let's try indenting or 3 columns (Empty, Content, Empty).
        $table = $section->addTable($tableStyle);
        $table->addRow();
        $table->addCell(3000)->addText("NAMA", $normalStyle);
        $table->addCell(500)->addText(":", $normalStyle);
        $table->addCell(5000)->addText($dataMahasiswa->name, $normalStyle);
        $table->addRow();
        $table->addCell(3000)->addText("NIM", $normalStyle);
        $table->addCell(500)->addText(":", $normalStyle);
        $table->addCell(5000)->addText($dataMahasiswa->nim, $normalStyle);
        $table->addRow();
        $table->addCell(3000)->addText("ANGKATAN", $normalStyle);
        $table->addCell(500)->addText(":", $normalStyle);
        $table->addCell(5000)->addText($dataMahasiswa->detailMahasiswa->angkatan ?? '-', $normalStyle);
        $table->addRow();
        $table->addCell(3000)->addText("JENJANG/PROGRAM STUDI", $normalStyle);
        $table->addCell(500)->addText(":", $normalStyle);
        $table->addCell(5000)->addText("S1 / " . ($dataMahasiswa->detailMahasiswa->prodi ?? '-'), $normalStyle);

        $section->addTextBreak(6);
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
        $section->addText("II. LAPORAN PRESTASI AKADEMIK", $subHeaderStyle);

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

         // d) Publikasi
         // Assuming independentActivities maps here? Or maybe we don't have a specific table for this in DB yet.
         // I'll used independentActivities for now or empty.
        $section->addText("d) Publikasi Ilmiah/Artikel/Karya Tulis/PKM yang dibuat selama menjadi mahasiswa Universitas Tiga Serangkai :", $normalStyle);
        $table = $section->addTable('BorderedTable');
        $table->addRow();
        $table->addCell(1000, ['bgColor' => $headerColor])->addText("No.", $boldStyle, $centerParam);
        $table->addCell(8000, ['bgColor' => $headerColor])->addText("Judul karya tulis/karya ilmiah", $boldStyle, $centerParam);

        // Use Cumulative Data
        $rowCount = max($allIndependent->count(), 2);
        for($i=0; $i<$rowCount; $i++) {
            $act = $allIndependent[$i] ?? null;
            $table->addRow();
            $table->addCell(1000)->addText($i+1, $normalStyle, $centerParam);
            $table->addCell(8000)->addText($act ? $act->activity_name : '', $normalStyle);
        }
        $section->addText("*) melampirkan copy hasil Karya Ilmiah/Karya Tulis/PKM yang telah dibuat", ['size' => 10], $leftParam);
        $section->addTextBreak(1);

        // --- SECTION IV: KEUANGAN ---
        $section->addText("IV. LAPORAN KEUANGAN", $subHeaderStyle);
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
        $section->addText("V. Kesan - pesan Mahasiswa", $subHeaderStyle);
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

        // Download
        $fileName = 'Laporan_Monev_' . $dataMahasiswa->nim . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'LaporanMonev');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
    public function exportPdf(string $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        // Cari laporan milik mahasiswa ybs
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
        ])
            ->where('laporan_id', $laporanId)
            ->where('nim', $dataMahasiswa->nim)
            ->firstOrFail();

        // Cek Status (hanya boleh jika Lolos atau Approved)
        if (!in_array(strtolower($laporan->status), ['lolos', 'approved'])) {
             return back()->with('error', 'Laporan belum disetujui, tidak dapat mengunduh PDF.');
        }

        // Fetch Cumulative Data (similar to Docx)
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

        // Gunakan view yang sama dengan Admin
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.pdf', compact(
            'laporan',
            'dataMahasiswa',
            'allAchievements',
            'allOrganizations',
            'allCommittees',
            'allIndependent'
        ));

        $fileName = 'Laporan_Monev_' . $dataMahasiswa->nim . '.pdf';
        return $pdf->download($fileName);
    }
}

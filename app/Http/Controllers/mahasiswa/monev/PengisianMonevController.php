<?php

namespace App\Http\Controllers\mahasiswa\monev;

use App\Http\Controllers\Controller;
use App\Models\monev\LaporanMonevMahasiswa;
use App\Models\semester\Periode;
use App\Models\users\DetailMahasiswa;
use App\Services\Penilaian\KegAkademikService;
use App\Services\Penilaian\KegKomiteService;
use App\Services\Penilaian\KegMandiriService;
use App\Services\Penilaian\KegOrgService;
use App\Services\Penilaian\PrestasiService;
use Illuminate\Support\Facades\Auth;

class PengisianMonevController extends Controller
{
    // Menampilkan halaman timeline monev yg dibuka
    public function showHalaman()
    {
        // ambil data mhs yg login
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        // ambil angkatan dari tabel detail_mahasiswa
        $detailMhs = DetailMahasiswa::where('nim', $dataMahasiswa->nim)->first();
        $angkatan = $detailMhs->angkatan;
        $prodi = $detailMhs->prodi;

        // jumlah semester S1/D3
        $totalSmt = str_contains($prodi, 'S1') ? 8 : 6;

        // query ke periode
        $periodeSemester = Periode::all()->toArray();
        $periodeAktifBanner = Periode::where('status', 'Aktif')->first();

        $timeline = [];

        for ($i = 1; $i <= $totalSmt; $i++) {

            $periode = $periodeSemester[$i - 1] ?? null;
            $namaSemester = "Semester " . $i;

            if ($periode) {
                $periodeAkademik = $periode['tahun_akademik'] . " " . $periode['semester'];
                $statusPeriode = $periode['status'];
                $semesterId = $periode['semester_id'];

                //  Cek laporan hanya jika statusnya Aktif atau Aktif-Khusus
                if (in_array($statusPeriode, ['Aktif', 'Aktif-Khusus'])) {
                    $laporan = LaporanMonevMahasiswa::where('nim', $dataMahasiswa->nim)
                        ->where('semester_id', $semesterId)
                        ->first();
                } else {
                    $laporan = null;
                }

                $timeline[] = [
                    'no' => $i,
                    'laporan_id' => $laporan->laporan_id ?? null,
                    'semester' => $namaSemester,
                    'periode' => $periodeAkademik,
                    // Aktif dan Aktif-Khusus sama-sama Dibuka
                    'status' => in_array($statusPeriode, ['Aktif', 'Aktif-Khusus']) ? 'Dibuka' : 'Ditutup',
                    // kalau dibuka dan laporan belum ada → Buat
                    'aksi' => $laporan ? 'Lihat' : (in_array($statusPeriode, ['Aktif', 'Aktif-Khusus']) ? 'Buat' : '-'),
                    // semester_id ngikut periode masing-masing, bukan lagi periodeAktif
                    'semester_id' => $semesterId,
                ];
            } else {
                // jika belum ada di tabel periode (misal semester 7/8 belum dibuat admin)
                $timeline[] = [
                    'no' => $i,
                    'laporan_id' => null,
                    'semester' => $namaSemester,
                    'periode' => null,
                    'status' => 'Ditutup',
                    'aksi' => '-',
                    'semester_id' => null,
                ];
            }
        }

        return view('mahasiswa.halaman-pengisian-laporan', compact('dataMahasiswa', 'periodeSemester', 'timeline', 'periodeAktifBanner'));
    }

    // Membuat laporan monev baru
    public function buatLaporanBaru(string $semesterId, string $semesterSekarang)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        // cek semester id dri param
        $cekSemesterId = Periode::where('semester_id', $semesterId)
            ->where('status', 'Aktif');
        if (!$cekSemesterId) {
            return back()->with('error', 'Periode tidak ada atau sudah ditutup!');
        }

        // strip semester sekarang, ambil angkanya
        $semesterAngka = (int) filter_var($semesterSekarang, FILTER_SANITIZE_NUMBER_INT);
        if ($semesterAngka < 0 || $semesterAngka > 8) {
            return back()->with('error', 'Semester tidak valid!');
        }

        // cek mhs sdh bikin laporan blm?
        $cekLaporanMhs = LaporanMonevMahasiswa::where('nim', $dataMahasiswa->nim)
            ->where('semester_id', $semesterId)
            ->first();
        if ($cekLaporanMhs) {
            return back()->with('error', 'Laporan sudah dibuat!');
        }

        // generate laporan_id
        $tanggal = now()->format('dmyHi');
        $laporanId = "LP" . $dataMahasiswa->nim . $tanggal;

        // simpan ke laporan_mahasiswa
        $laporan = LaporanMonevMahasiswa::create([
            'laporan_id' => $laporanId,
            'nim' => $dataMahasiswa->nim,
            'semester_id' => $semesterId,
            'semester' => $semesterAngka,
            'status' => 'Draft'
        ]);

        return redirect()->route('mahasiswa.lihat-laporan', parameters: ['laporanId' => $laporan->laporan_id]);
    }
    // Menampilkan halaman pengisian aktivitas mhs (monev)
    public function showHalamanIsiMonev(string $laporanId)
    {
        // ambil data mhs yg login
        $dataMahasiswa = Auth::guard('mahasiswa')->user();
        // ambil data monev mhs
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

        return view('mahasiswa.laporan-monev', compact(
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
        ));
    }
    // Mengajukan laporan menjadi Pending
    public function ajukanLaporanMonev(string $laporanId)
    {
        // ambil data mhs yg login
        $dataMahasiswa = Auth::guard('mahasiswa')->user();
        // ambil data monev mhs
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
        ])
            ->where('laporan_id', $laporanId)
            ->where('nim', $dataMahasiswa->nim)
            ->first();

        if (!$laporan) {
            return back()->with('error', 'Laporan tidak ditemukan.');
        }

        // inisiasi service
        $penilaianKegAkademik = app(KegAkademikService::class);
        $penilaianKegOrganisasi = app(KegOrgService::class);
        $penilaianKegKomite = app(KegKomiteService::class);
        $penilaianPrestasi = app(PrestasiService::class);
        $penilaianKegMandiri = app(KegMandiriService::class);


        // ==== Hitung nilai Kegiatan Akademik ====
        foreach ($laporan->academicActivities as $item) {
            $nilai = $penilaianKegAkademik->hitung($item->activity_type ?? '');
            $item->update(['points' => $nilai]);
        }

        // ==== Hitung nilai Kegiatan Organisasi ====
        foreach ($laporan->organizationActivities as $item) {
            $nilai = $penilaianKegOrganisasi->hitung(
                $item->position ?? '',
                $item->level ?? ''
            );
            $item->update(['points' => $nilai]);
        }

        // ==== Hitung nilai Kegiatan Komite ====
        foreach ($laporan->committeeActivities as $item) {
            $nilai = $penilaianKegKomite->hitung(
                $item->activity_type ?? '',
                $item->level ?? '',
                $item->participation ?? ''
            );
            $item->update(['points' => $nilai]);
        }

        // ==== Hitung nilai Prestasi ====
        foreach ($laporan->studentAchievements as $item) {
            $nilai = $penilaianPrestasi->hitung(
                $item->achievements_type ?? '',
                $item->level ?? '',
                $item->award ?? ''
            );
            $item->update(['points' => $nilai]);
        }

        // ==== Hitung nilai Kegiatan Mandiri ====
        foreach ($laporan->independentActivities as $item) {
            $nilai = $penilaianKegMandiri->hitung($item->activity_type ?? '');
            $item->update(['points' => $nilai]);
        }


        // update status tabel laporan mahasiswa
        $laporan->update(['status' => 'Pending']);

        foreach (
            [
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
            ] as $relation
        ) {
            $laporan->$relation()->update(['status' => 'Pending']);
        }

        return redirect()->route('mahasiswa.detail-laporan')->with('success', 'Laporan Berhasil Diajukan Dengan Status Pending');
    }
}

<?php

namespace App\Http\Controllers\mahasiswa\monev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\monev\AcademicActivities;
use App\Models\monev\AcademicReports;
use App\Models\monev\CommitteeActivities;
use App\Models\monev\Evaluations;
use App\Models\monev\IndependentActivities;
use App\Models\monev\LaporanMonevMahasiswa;
use App\Models\monev\OrganizationActivities;
use App\Models\monev\StudentAchievements;
use App\Models\monev\TargetAcademicActivities;
use App\Models\monev\TargetAchievements;
use App\Models\monev\TargetIdependentActivities;
use App\Models\monev\TargetNextSemester;
use App\Models\semester\Periode;
use App\Models\users\DetailMahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PengisianMonevController extends Controller
{
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

        // ambil periode semester
        $periodeSemester = Periode::all()->toArray();

        // ambil periode yg aktif
        $periodeAktif = Periode::where('status', 'Aktif')->first();

        $timeline = [];
        for ($i = 1; $i <= $totalSmt; $i++) {
            $namaSemester = "Semester " . $i;
            $periodeAkademik = $periodeSemester[$i - 1]['tahun_akademik'] . " " . $periodeSemester[$i - 1]['semester'];
            $statusPeriode = $periodeSemester[$i - 1]['status'];

            $timeline[] = [
                'no' => $i,
                'semester' => $namaSemester,
                'periode' => $periodeAkademik ?? null,
                'status' => $statusPeriode === 'Aktif' ? 'Dibuka' : 'Ditutup/Selesai',
            ];
        }

        return view('mahasiswa.halaman-pengisian-laporan', compact('dataMahasiswa', 'periodeSemester', 'periodeAktif', 'timeline'));
    }

    public function buatLaporanBaru()
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();
        $periodeAktif = Periode::where('status', 'Aktif')->first();

        if (!$periodeAktif) {
            return back()->with('error', 'Tidak ada periode aktif.');
        }

        // generate laporan_id
        $tanggal = now()->format('dmyHi');
        $laporanId = "LP" . $dataMahasiswa->nim . $tanggal;

        // simpan ke laporan_mahasiswa
        $laporan = LaporanMonevMahasiswa::create([
            'laporan_id' => $laporanId,
            'nim' => $dataMahasiswa->nim,
            'semester_id' => $periodeAktif->semester_id,
            'status' => 'Draft'
        ]);

        return redirect()->route('mahasiswa.isi-monev', parameters: ['laporan_id' => $laporan->laporan_id]);
    }

    public function showHalamanIsiMonev($laporanId)
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

        // parsing setiap model
        $parsingAcademicReports = $laporan->academicReports->map(function ($report, $i) {
            return [
                $i + 1,
                $report->semester,
                $report->ips,
                $report->ipk,
                $report->bukti_url, //Sementara
                $report->status,
            ];
        });
        $parsingAcademicActivities = $laporan->academicActivities->map(function ($report, $i) {
            return [
                $i + 1,
                $report->activity_name,
                $report->activity_type,
                $report->participation,
                $report->place,
                $report->start_date,
                $report->end_date,
                $report->bukti_url, //Sementara
                $report->status,
            ];
        });
        $parsingOrganizationActivities = $laporan->organizationActivities->map(function ($report, $i) {
            return [
                $i + 1,
                $report->ukm_name,
                $report->activity_name,
                $report->level,
                $report->position,
                $report->place,
                $report->start_date,
                $report->end_date,
                $report->bukti_url, //Sementara
                $report->status,
            ];
        });
        $parsingCommitteeActivities = $laporan->committeeActivities->map(function ($report, $i) {
            return [
                $i + 1,
                $report->activity_name,
                $report->activity_type,
                $report->participation,
                $report->level,
                $report->place,
                $report->start_date,
                $report->end_date,
                $report->bukti_url, //Sementara
                $report->status,
            ];
        });
        $parsingAchievements = $laporan->studentAchievements->map(function ($report, $i) {
            return [
                $i + 1,
                $report->achievements_name,
                $report->scope,
                $report->is_group ? 1 === 'Kelompok' : 'Individu',
                $report->level,
                $report->award,
                $report->place,
                $report->start_date,
                $report->end_date,
                $report->bukti_url, //Sementara
                $report->status,
            ];
        });
        $parsingIndependentActivities = $laporan->independentActivities->map(function ($report, $i) {
            return [
                $i + 1,
                $report->activity_name,
                $report->activity_type,
                $report->participation,
                $report->place,
                $report->start_date,
                $report->end_date,
                $report->bukti_url, //Sementara
                $report->status,
            ];
        });
        $parsingEvaluations = $laporan->evaluations->map(function ($report, $i) {
            return [
                $i + 1,
                $report->support_factors,
                $report->barrier_factors, //Sementara
                $report->status,
            ];
        });
        $parsingNextReports = $laporan->targetNextSemester->map(function ($report, $i) {
            return [
                $i + 1,
                $report->semester,
                $report->target_ips,
                $report->target_ipk,
                $report->status,
            ];
        });
        $parsingNextAcademicActivities = $laporan->targetAcademicActivities->map(function ($report, $i) {
            return [
                $i + 1,
                $report->activity_name,
                $report->strategy,
                $report->status,
            ];
        });
        $parsingNextAchievements = $laporan->targetAchievements->map(function ($report, $i) {
            return [
                $i + 1,
                $report->achievements_name,
                $report->level,
                $report->award,
                $report->status,
            ];
        });
        $parsingNextIndependentActivities = $laporan->targetIndependentActivities->map(function ($report, $i) {
            return [
                $i + 1,
                $report->activity_name,
                $report->participation,
                $report->strategy,
                $report->status,
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

    public function submitNilaiIPKnIPS(Request $request, $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'semester' => 'required|integer|min:1|max:8',
            'ips' => 'required|integer|min:0|max:4',
            'ipk' => 'required|integer|min:0|max:4',
            'bukti'    => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        AcademicReports::create([
            'laporan_id' => $laporanId,
            'nim'        => $dataMahasiswa->nim,
            'semester'   => $validated['semester'],
            'ips'        => $validated['ips'],
            'ipk'        => $validated['ipk'],
            'bukti_url'  => 'Tidak Ada', //Sementara ini dulu hehe
            'status'     => 'Draft',
        ]);

        return redirect()->back()->with('success', 'Data IPK dan IPS berhasil ditambah!');
    }
    public function submitKegAKademik(Request $request, $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'nama-kegiatan' => 'required|string|min:1|max:255',
            'tipe-kegiatan' => 'required|string|min:1|max:255',
            'keikutsertaan' => 'required|string|min:1|max:100',
            'tempat' => 'required|string|min:1|max:255',
            'tanggal-mulai' => 'required',
            'tanggal-selesai' => 'required',
            'bukti' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        AcademicActivities::create([
            'laporan_id' => $laporanId,
            'nim'        => $dataMahasiswa->nim,
            'activity_name' => $validated['nama-kegiatan'],
            'activity_type' => $validated['tipe-kegiatan'],
            'participation' => $validated['keikutsertaan'],
            'place' => $validated['tempat'],
            'start_date' => $validated['tanggal-mulai'],
            'end_date' => $validated['tanggal-selesai'],
            'bukti_url' => 'Tidak Ada',
            'status' => 'Draft',
        ]);

        return redirect()->back()->with('success', 'Data Kegiatan Akademik berhasil ditambah!');
    }
    public function submitKegOrg(Request $request, $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'nama-ukm' => 'required|string|min:1|max:255',
            'nama-kegiatan' => 'required|string|min:1|max:255',
            'tingkat' => 'required|string|min:1|max:100',
            'posisi' => 'required|string|min:1|max:100',
            'tempat' => 'required|string|min:1|max:255',
            'tanggal-mulai' => 'required',
            'tanggal-selesai' => 'required',
            'bukti' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        AcademicActivities::create([
            'laporan_id' => $laporanId,
            'nim'        => $dataMahasiswa->nim,
            'activity_name' => $validated['nama-kegiatan'],
            'activity_type' => $validated['tipe-kegiatan'],
            'participation' => $validated['keikutsertaan'],
            'place' => $validated['tempat'],
            'start_date' => $validated['tanggal-mulai'],
            'end_date' => $validated['tanggal-selesai'],
            'bukti_url' => 'Tidak Ada',
            'status' => 'Draft',
        ]);

        return redirect()->back()->with('success', 'Data Kegiatan Akademik berhasil ditambah!');
    }
    public function submitKegKomite(Request $request, $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'nama-kegiatan' => 'required|string|min:1|max:255',
            'tipe-kegiatan' => 'required|string|min:1|max:255',
            'keikutsertaan' => 'required|string|min:1|max:100',
            'tengkat' => 'required|string|min:1|max:100',
            'tempat' => 'required|string|min:1|max:255',
            'tanggal-mulai' => 'required',
            'tanggal-selesai' => 'required',
            'bukti' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        CommitteeActivities::create([
            'laporan_id' => $laporanId,
            'nim'        => $dataMahasiswa->nim,
            'activity_name' => $validated['nama-kegiatan'],
            'activity_type' => $validated['tipe-kegiatan'],
            'participation' => $validated['keikutsertaan'],
            'level' => $validated['tingkat'],
            'place' => $validated['tempat'],
            'start_date' => $validated['tanggal_mulai'],
            'end_date' => $validated['tanggal_selesai'],
            'bukti_url' => $validated['bukti'],
            'status' => 'Draft'
        ]);

        return redirect()->back()->with('success', 'Data Kegiatan Kepanitiaan atau Penugasan berhasil ditambah!');
    }
    public function submitAchievemnts(Request $request, $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'nama-prestasi' => 'required|string|min:1|max:255',
            'cakupan' => ['required', Rule::in(['Pemerintahan', 'Non-Pemerintahan'])],
            'kelompok-individu' => 'required|in:0,1',
            'tengkat' => ['required', Rule::in(['Internasional', 'Nasional', 'Regional', 'Perguruan Tinggi'])],
            'raihan' => ['required', Rule::in(['Juara 1', 'Juara 2', 'Juara 3', 'Juara Harapan'])],
            'tempat' => 'required|string|min:1|max:255',
            'tanggal-mulai' => 'required',
            'tanggal-selesai' => 'required',
            'bukti' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        StudentAchievements::create([
            'laporan_id' => $laporanId,
            'nim' => $dataMahasiswa->nim,
            'achievements_name' => $validated['nama-prestasi'],
            'scope' => $validated['kelompok-individu'],
            'level' => $validated['tingkat'],
            'award' => $validated['raihan'],
            'place' => $validated['tempat'],
            'start_date' => $validated['tanggal-mulai'],
            'end_date' => $validated['tanggal-selesai'],
            'bukti_url' => 'Tidak Ada',
            'status' => 'Draft',
        ]);
    }
    public function submitKegMandiri(Request $request, $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        $vaalidated = $request->validate([
            'nama-kegiatan' => 'required|string|min:1|max:255',
            'tipe-kegiatan' => 'required|string|min:1|max:255',
            'keikutsertaan' => 'required|string|min:1|max:255',
            'tempat' => 'required|string|min:1|max:255',
            'tanggal-mulai' => 'required',
            'tanggal-selesai' => 'required',
            'bukti' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        Evaluations::create([
            'laporan_id' => $laporanId,
            'nim' => $dataMahasiswa->nim,
            'activity_name' => $vaalidated['nama-kegiatan'],
            'activity_type' => $vaalidated['tipe-kegiatan'],
            'participation' => $vaalidated['keikutsertaan'],
            'place' => $vaalidated['tempat'],
            'start_date' => $vaalidated['tanggal-mulai'],
            'end_date' => $vaalidated['tanggal-selesao'],
            'bukti_url' => 'Tidak Ada',
            'status' => 'Draft',
        ]);

        return  redirect()->back()->with('success', 'Data Kegiatan Mandiri berhasil ditambahkan!');
    }
    public function submitEvaluasi(Request $request, $laporanId) {}
    public function submitTargetIPSnIPK(Request $request, $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'semester' => 'required|integer|min:1|max:8',
            'target-ips' => 'required|integer|min:0|max:4:',
            'target-ipk' => 'required|integer|min:0|max:4:',
        ]);

        TargetNextSemester::create([
            'laaporan_id' => $laporanId,
            'nim' => $dataMahasiswa->nim,
            'semester' => $validated['semester'],
            'target_ips' => $validated['target-ips'],
            'target_ipk' => $validated['target-ipk'],
            'status' => 'Draft',
        ]);

        return redirect()->back()->with('success', 'Data Target IPK dan IPS berhasl ditambah!');
    }
    public function submitTargetKegAkademik(Request $request, $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'nama-kegiatan' => 'required|string|min:1|max:255',
            'rencana-strategi' => 'required|string|min:1|max:255',
            'keikutsertaan' => 'required|string|min:1|max:100',
        ]);

        TargetAcademicActivities::create([
            'laporan_id' => $laporanId,
            'nim' => $dataMahasiswa->nim,
            'activity_name' => $validated['nama-kegiatan'],
            'strategy' => $validated['rencana-strategi'],
            'partisipation' => $validated['keikutsertaan'],
            'status' => 'Draft',
        ]);

        return redirect()->back()->with('success', 'Data Target Kegiatan Akademik berhasil ditambahkan!');
    }
    public function submitTargetAchievements(Request $request, $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'nama-prestasi' => 'required|string|min:1|max:255',
            'tingkat' => 'required|string|min:1|max:255',
            'raihan' => 'required|string|min:1|max:100',
        ]);

        TargetAchievements::create([
            'laporan_id' => $laporanId,
            'nim' => $dataMahasiswa->nim,
            'achievements_name' => $validated['nama-prestasi'],
            'level' => $validated['tingkat'],
            'award' => $validated['raihan'],
            'status' => 'Draft',
        ]);

        return redirect()->back()->with('success', 'Data Target Prestasi berhasil ditambahkan!');
    }
    public function submitTargetKegMandiri(Request $request, $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'nama-kegiatan' => 'required|string|min:1|max:255',
            'rencana-strategi' => 'required|string|min:1|max:255',
            'keikutsertaan' => 'required|string|min:1|max:100',
        ]);

        TargetIdependentActivities::create([
            'laporan_id' => $laporanId,
            'nim' => $dataMahasiswa->nim,
            'activity_name' => $validated['nama-kegiatan'],
            'strategy' => $validated['rencana-strategi'],
            'participation' => $validated['keikutsertaan'],
            'status' => 'Draft',
        ]);

        return redirect()->back()->with('success', 'Data Target Kegiatan Mandiri berhasil ditambah!');
    }
}

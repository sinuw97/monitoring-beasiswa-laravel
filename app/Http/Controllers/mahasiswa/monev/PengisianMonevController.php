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

        // ambil periode semester
        $periodeSemester = Periode::all()->toArray();

        // ambil periode yg aktif
        $periodeAktif = Periode::where('status', 'Aktif')->first();

        $timeline = [];
        for ($i = 1; $i <= $totalSmt; $i++) {
            $namaSemester = "Semester " . $i;
            $periodeAkademik = $periodeSemester[$i - 1]['tahun_akademik'] . " " . $periodeSemester[$i - 1]['semester'];
            $statusPeriode = $periodeSemester[$i - 1]['status'];

            // apakah mhs ini sdh buat laporan?
            $laporan = LaporanMonevMahasiswa::where('nim', $dataMahasiswa->nim)
                ->where('semester_id', $periodeAktif['semester_id'])
                ->first();

            $timeline[] = [
                'no' => $i,
                'laporan_id' => $laporan->laporan_id,
                'semester' => $namaSemester,
                'periode' => $periodeAkademik ?? null,
                'status' => $statusPeriode === 'Aktif' ? 'Dibuka' : 'Ditutup',
                'aksi' => $laporan ? 'Lihat' : 'Buat',
                'semester_id' => $periodeAktif['semester_id'],
            ];
        }

        return view('mahasiswa.halaman-pengisian-laporan', compact('dataMahasiswa', 'periodeSemester', 'periodeAktif', 'timeline'));
    }

    // Membuat laporan monev baru
    public function buatLaporanBaru($semesterId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        // cek semester id dri param
        $cekSemesterId = Periode::where('semester_id', $semesterId)
            ->where('status', 'Aktif');
        if (!$cekSemesterId) {
            return back()->with('error', 'Periode tidak ada atau sudah ditutup!');
        }

        // cek mhs sdh bikin laporan blm?
        $cekLaporanMhs = LaporanMonevMahasiswa::where('nim', $dataMahasiswa->nim)
            ->where('semester_id', $semesterId)
            ->first();
        if($cekLaporanMhs) {
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
            'status' => 'Draft'
        ]);

        return redirect()->route('mahasiswa.isi-monev', parameters: ['laporan_id' => $laporan->laporan_id]);
    }
    // Menampilkan halaman pengisian aktivitas mhs (monev)
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
                'scope' => $report->scope,
                'is-group' => $report->is_group ? 1 === 'Kelompok' : 'Individu',
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
    public function ajukanLaporanMonev($laporanId)
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

        return back()->with('success', 'Laporan berhasil diajukan dengan status Pending.');
    }

    public function submitNilaiIPKnIPS(Request $request, $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'semester' => 'required|integer|min:1|max:8',
            'ips' => 'required|numeric|between:0,4',
            'ipk' => 'required|numeric|between:0,4',
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

        OrganizationActivities::create([
            'laporan_id' => $laporanId,
            'nim'        => $dataMahasiswa->nim,
            'ukm_name' => $validated['nama-ukm'],
            'activity_name' => $validated['nama-kegiatan'],
            'level' => $validated['tingkat'],
            'position' => $validated['posisi'],
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
        // dd($request->all());

        $validated = $request->validate([
            'nama-kegiatan' => 'required|string|min:1|max:255',
            'tipe-kegiatan' => 'required|string|min:1|max:255',
            'keikutsertaan' => 'required|string|min:1|max:100',
            'tingkat' => 'required|string|min:1|max:100',
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
            'start_date' => $validated['tanggal-mulai'],
            'end_date' => $validated['tanggal-selesai'],
            'bukti_url' => "Tidak Ada", //Sementara
            'status' => 'Draft',
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
            'tingkat' => ['required', Rule::in(['Internasional', 'Nasional', 'Regional', 'Perguruan Tinggi'])],
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
            'scope' => $validated['cakupan'],
            'level' => $validated['tingkat'],
            'award' => $validated['raihan'],
            'place' => $validated['tempat'],
            'start_date' => $validated['tanggal-mulai'],
            'end_date' => $validated['tanggal-selesai'],
            'bukti_url' => 'Tidak Ada',
            'status' => 'Draft',
        ]);

        return redirect()->back()->with('success', 'Data Prestasi Mahasiswa berhasil ditambah!');
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

        IndependentActivities::create([
            'laporan_id' => $laporanId,
            'nim' => $dataMahasiswa->nim,
            'activity_name' => $vaalidated['nama-kegiatan'],
            'activity_type' => $vaalidated['tipe-kegiatan'],
            'participation' => $vaalidated['keikutsertaan'],
            'place' => $vaalidated['tempat'],
            'start_date' => $vaalidated['tanggal-mulai'],
            'end_date' => $vaalidated['tanggal-selesai'],
            'bukti_url' => 'Tidak Ada',
            'status' => 'Draft',
        ]);

        return  redirect()->back()->with('success', 'Data Kegiatan Mandiri berhasil ditambahkan!');
    }
    public function submitEvaluasi(Request $request, $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'faktor-pendukung' => 'required|string',
            'faktor-penghambat' => 'required|string'
        ]);

        Evaluations::create([
            'laporan_id' => $laporanId,
            'nim' => $dataMahasiswa->nim,
            'support_factors' => $validated['faktor-pendukung'],
            'barrier_factors' => $validated['faktor-penghambat'],
            'status' => 'Draft',
        ]);

        return redirect()->back()->with('success', 'Data evaluasi berhasil ditambahkan!');
    }
    public function submitTargetIPSnIPK(Request $request, $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'semester' => 'required|integer|min:1|max:8',
            'target-ips' => 'required|numeric|between:0,4',
            'target-ipk' => 'required|numeric|between:0,4',
        ]);

        TargetNextSemester::create([
            'laporan_id' => $laporanId,
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
        ]);

        TargetAcademicActivities::create([
            'laporan_id' => $laporanId,
            'nim' => $dataMahasiswa->nim,
            'activity_name' => $validated['nama-kegiatan'],
            'strategy' => $validated['rencana-strategi'],
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

    // Edit
    public function updateNilaiIPKnIPS(Request $request, $idData)
    {
        // Cek data apakaha ada?
        $report = AcademicReports::findOrFail($idData);

        $validated = $request->validate([
            'semester' => 'required|integer|min:1|max:8',
            'ips' => 'required|numeric|between:0,4',
            'ipk' => 'required|numeric|between:0,4',
            'bukti'    => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $report->semester = $validated['semester'];
        $report->ips = $validated['ips'];
        $report->ipk = $validated['ipk'];
        $report->bukti_url = "Tidak Ada";
        $report->save();

        return redirect()->back()->with('success', 'Data IPS dan IPK berhasil diupdate');
    }
    public function updateKegAKademik(Request $request, $idData)
    {
        $report = AcademicActivities::findOrFail($idData);

        $validated = $request->validate([
            'nama-kegiatan' => 'required|string|min:1|max:255',
            'tipe-kegiatan' => 'required|string|min:1|max:255',
            'keikutsertaan' => 'required|string|min:1|max:100',
            'tempat' => 'required|string|min:1|max:255',
            'tanggal-mulai' => 'required',
            'tanggal-selesai' => 'required',
            'bukti' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $report->activity_name = $validated['nama-kegiatan'];
        $report->activity_type = $validated['tipe-kegiatan'];
        $report->participation = $validated['keikutsertaan'];
        $report->place = $validated['tempat'];
        $report->start_date = $validated['tanggal-mulai'];
        $report->end_date = $validated['tanggal-selesai'];
        $report->bukti_url = "Tidak Ada";
        $report->save();

        return redirect()->back()->with('success', 'Data Kegiatan Akademik berhasil diupdate');
    }
    public function updateKegOrg(Request $request, $idData)
    {
        $report = OrganizationActivities::findOrFail($idData);

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

        $report->ukm_name = $validated['nama-ukm'];
        $report->activity_name = $validated['nama-kegiatan'];
        $report->level = $validated['tingkat'];
        $report->position = $validated['posisi'];
        $report->place = $validated['tempat'];
        $report->start_date = $validated['tanggal-mulai'];
        $report->end_date = $validated['tanggal-selesai'];
        $report->bukti_url = "Tidak Ada";
        $report->save();

        return redirect()->back()->with('success', 'Data Kegiatan Organisasi berhasil diupdate');
    }
    public function updateKegKomite(Request $request, $idData)
    {
        $report = CommitteeActivities::findOrFail($idData);

        $validated = $request->validate([
            'nama-kegiatan' => 'required|string|min:1|max:255',
            'tipe-kegiatan' => 'required|string|min:1|max:255',
            'keikutsertaan' => 'required|string|min:1|max:100',
            'tingkat' => 'required|string|min:1|max:100',
            'tempat' => 'required|string|min:1|max:255',
            'tanggal-mulai' => 'required',
            'tanggal-selesai' => 'required',
            'bukti' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $report->activity_name = $validated['nama-kegiatan'];
        $report->activity_type = $validated['tipe-kegiatan'];
        $report->participation = $validated['keikutsertaan'];
        $report->level = $validated['tingkat'];
        $report->place = $validated['tempat'];
        $report->start_date = $validated['tanggal-mulai'];
        $report->end_date = $validated['tanggal-selesai'];
        $report->bukti_url = 'Tidak Ada';
        $report->save();

        return redirect()->back()->with('success', 'Data Kegiatan Penugasan berhasil diupdate');
    }
    public function updateAchievemnts(Request $request, $idData)
    {
        $report = StudentAchievements::findOrFail($idData);

        $validated = $request->validate([
            'nama-prestasi' => 'required|string|min:1|max:255',
            'cakupan' => ['required', Rule::in(['Pemerintahan', 'Non-Pemerintahan'])],
            'kelompok-individu' => 'required|in:0,1',
            'tingkat' => ['required', Rule::in(['Internasional', 'Nasional', 'Regional', 'Perguruan Tinggi'])],
            'raihan' => ['required', Rule::in(['Juara 1', 'Juara 2', 'Juara 3', 'Juara Harapan'])],
            'tempat' => 'required|string|min:1|max:255',
            'tanggal-mulai' => 'required',
            'tanggal-selesai' => 'required',
            'bukti' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $report->achievements_name = $validated['nama-prestasi'];
        $report->scope = $validated['kelompok-individu'];
        $report->level = $validated['tingkat'];
        $report->award = $validated['raihan'];
        $report->place = $validated['tempat'];
        $report->start_date = $validated['tanggal-mulai'];
        $report->end_date = $validated['tanggal-selesai'];
        $report->bukti_url = 'Tidak Ada';
        $report->save();

        return redirect()->back()->with('success', 'Data Prestasi berhasil diupdate');
    }
    public function updateKegMandiri(Request $request, $idData)
    {
        $report = IndependentActivities::findOrFail($idData);

        $vaalidated = $request->validate([
            'nama-kegiatan' => 'required|string|min:1|max:255',
            'tipe-kegiatan' => 'required|string|min:1|max:255',
            'keikutsertaan' => 'required|string|min:1|max:255',
            'tempat' => 'required|string|min:1|max:255',
            'tanggal-mulai' => 'required',
            'tanggal-selesai' => 'required',
            'bukti' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $report->activity_name = $vaalidated['nama-kegiatan'];
        $report->activity_type = $vaalidated['tipe-kegiatan'];
        $report->participation = $vaalidated['keikutsertaan'];
        $report->place = $vaalidated['tempat'];
        $report->start_date = $vaalidated['tanggal-mulai'];
        $report->end_date = $vaalidated['tanggal-selesai'];
        $report->bukti_url = 'idak Ada';
        $report->save();

        return redirect()->back()->with('success', 'Data Kegiatan Mandiri berhasil diupdate');
    }
    public function updateEvaluasi(Request $request, $idData)
    {

        $report = Evaluations::findOrFail($idData);

        $validated = $request->validate([
            'faktor-pendukung' => 'required|string',
            'faktor-penghambat' => 'required|string'
        ]);

        $report->support_factors = $validated['faktor-pendukung'];
        $report->barrier_factors = $validated['faktor-penghambat'];
        $report->save();

        return redirect()->back()->with('success', 'Data Evaluasi berhasil diupdate');
    }
    public function updateTargetIPSnIPK(Request $request, $idData)
    {

        $report = TargetNextSemester::findOrFail($idData);

        $validated = $request->validate([
            'semester' => 'required|integer|min:1|max:8',
            'target-ips' => 'required|numeric|between:0,4',
            'target-ipk' => 'required|numeric|between:0,4',
        ]);

        $report->semester = $validated['semester'];
        $report->target_ips = $validated['target-ips'];
        $report->target_ipk = $validated['target-ipk'];
        $report->save();

        return redirect()->back()->with('success', 'Data Target IPK dan IPS berhasil diupdate');
    }
    public function updateTargetKegAkademik(Request $request, $idData)
    {

        $report = TargetAcademicActivities::findOrFail($idData);

        $validated = $request->validate([
            'nama-kegiatan' => 'required|string|min:1|max:255',
            'rencana-strategi' => 'required|string|min:1|max:255',
        ]);

        $report->activity_name = $validated['nama-kegiatan'];
        $report->strategy = $validated['rencana-strategi'];
        $report->save();

        return redirect()->back()->with('success', 'Data Target Kegiatan Akademik berhasil diupdate');
    }
    public function updateTargetAchievements(Request $request, $idData)
    {

        $report = TargetAchievements::findOrFail($idData);

        $validated = $request->validate([
            'nama-prestasi' => 'required|string|min:1|max:255',
            'tingkat' => 'required|string|min:1|max:255',
            'raihan' => 'required|string|min:1|max:100',
        ]);

        $report->achievements_name = $validated['nama-prestasi'];
        $report->level = $validated['tingkat'];
        $report->award = $validated['raihan'];
        $report->save();

        return redirect()->back()->with('success', 'Data Target Kegiatan Akademik berhasil diupdate');
    }
    public function updateTargetKegMandiri(Request $request, $idData)
    {

        $report = TargetIdependentActivities::findOrFail($idData);

        $validated = $request->validate([
            'nama-kegiatan' => 'required|string|min:1|max:255',
            'rencana-strategi' => 'required|string|min:1|max:255',
            'keikutsertaan' => 'required|string|min:1|max:100',
        ]);

        $report->activity_name = $validated['nama-kegiatan'];
        $report->strategy = $validated['rencana-strategi'];
        $report->participation = $validated['keikutsertaan'];
        $report->save();

        return redirect()->back()->with('success', 'Data Target Kegiatan Akademik berhasil diupdate');
    }
}

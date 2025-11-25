<?php

namespace App\Http\Controllers\admin\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\monev\LaporanMonevMahasiswa;
use App\Models\users\Admin;
use App\Models\users\Mahasiswa;
use App\Models\semester\Periode;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardAdminController extends Controller
{
    public function showDashboard() {
        $admin = Auth::guard('admin')->user();
        $dataAdmin = Admin::where('email', $admin->email)
            ->where('user_id', $admin->user_id)
            ->first();

        $dataAdmin->makeHidden(['password']);
        $jmlMahasiswwa = Mahasiswa::count();
        $jmlLaporan= LaporanMonevMahasiswa::join('periode', 'laporan_mahasiswa.semester_id', '=', 'periode.semester_id')->where('periode.status', '=', 'Aktif')->where('laporan_mahasiswa.status', '!=', 'Draft')->count();
        $dataPeriode = Periode::orderBy('semester_id', 'desc')->paginate(10);
        $anyActivePeriod = Periode::where('status', 'Aktif')->exists();

        return view('admin.dashboard', compact(['dataAdmin'], ['jmlMahasiswwa'], ['dataPeriode'], ['jmlLaporan'], 'anyActivePeriod'));
    }

    public function showLaporan($laporanId){
        $admin = Auth::guard('admin')->user();

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
            ->first();

        if (!$laporan) {
            return back()->with('error', 'Laporan tidak ditemukan.');
        }

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

        $dataMahasiswa = Mahasiswa::where('nim', '=', $laporan->nim)->first();

        // return dd($parsingAcademicReports);

        return view('admin.laporan-monev', compact(
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

    public function addPeriode(Request $request){
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
        ]);

        $firstDataPeriode = Periode::orderBy('semester_id', 'desc')->first();
        $secondDataPeriode = Periode::orderBy('semester_id', 'desc')->skip(1)->take(1)->first();

        if($firstDataPeriode->tahun_akademik !== $secondDataPeriode->tahun_akademik){
            Periode::create([
                'semester_id' => substr($firstDataPeriode->semester_id, 0, -1).'2',
                'tahun_akademik' => $firstDataPeriode->tahun_akademik,
                'semester' => 'Genap',
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status' => 'Non-Aktif',
            ]);
        }else{
            $tahun = (int) substr($firstDataPeriode->tahun_akademik, 0, -5) + 1;
            Periode::create([
                'semester_id' => 'SM'.$tahun.'01',
                'tahun_akademik' => $tahun.'/'.$tahun+1,
                'semester' => 'Ganjil',
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status' => 'Non-Aktif',
            ]);
        }

        return redirect('/admin/dashboard')->with('success', 'Periode berhasil ditambahkan.');
    }

    public function deletePeriode($id){
        Periode::where('semester_id', $id)->delete();

        return redirect('/admin/dashboard')->with('success', 'Periode berhasil dihapus.');
    }

    public function editPeriode(Request $request, $id){
        $request->validate([
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
        ]);

        $periode = Periode::where('semester_id', $id)->first();
        
        if ($periode) {
            $periode->update([
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
            ]);
            return redirect('/admin/dashboard')->with('success', 'Periode berhasil diubah.');
        }

        return redirect('/admin/dashboard')->with('error', 'Periode tidak ditemukan.');
    }

    public function activatePeriode($id) {
        $periode = Periode::where('semester_id', $id)->first();
        $activePeriode = Periode::where('status', 'Aktif')->first();

        if ($activePeriode) {
            $periode->update([
                'status' => 'Aktif Sementara',
            ]);
            return redirect('/admin/dashboard')->with('success', 'Periode berhasil diaktifkan sementara.');
        } else {
            $periode->update([
                'status' => 'Aktif',
            ]);
            return redirect('/admin/dashboard')->with('success', 'Periode berhasil diaktifkan.');
        }
    }

    public function deactivatePeriode($id) {
        $periode = Periode::where('semester_id', $id)->first();
        
        $periode->update([
            'status' => 'Non-Aktif',
        ]);

        return redirect('/admin/dashboard')->with('success', 'Periode berhasil dinonaktifkan.');
    }
}

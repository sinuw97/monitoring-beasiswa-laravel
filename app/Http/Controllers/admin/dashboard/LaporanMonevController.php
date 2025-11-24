<?php

namespace App\Http\Controllers\admin\dashboard;

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
                ->where('semester_id', '=', $periodeFilter ?? $semesterId);

            // Filter angkatan
            if (!empty($angkatan)) {
                $query->whereRaw('LEFT(mahasiswa.nim, 2) = ?', [$angkatan]);
            }

            // Filter status
            if (!empty($status)) {
                $query->where('laporan_mahasiswa.status', '=', $status);
            }

            // Search by NIM or Nama
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('mahasiswa.nim', 'like', "%{$search}%")
                    ->orWhere('mahasiswa.name', 'like', "%{$search}%");
                });
            }

            // Ambil data dengan pagination
            $dataLaporan = $query->select('laporan_mahasiswa.*', 'mahasiswa.*')
                ->paginate(50)
                ->appends($request->query());

            // Ambil semua periode untuk filter dropdown
            $daftarPeriode = Periode::orderBy('tahun_akademik', 'desc')->get();

            // Ambil daftar angkatan
            $daftarAngkatan = Mahasiswa::selectRaw('LEFT(nim, 2) as angkatan')
            ->distinct()
            ->get();
        }else{
            $dataLaporan = [];
            $periode = [];
            
            // Ambil semua periode untuk filter dropdown
            $daftarPeriode = Periode::orderBy('tahun_akademik', 'desc')->get();

            // Ambil daftar angkatan
            $daftarAngkatan = Mahasiswa::selectRaw('LEFT(nim, 2) as angkatan')
            ->distinct()
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
        $targetIdependentActivities = TargetIdependentActivities::where('laporan_id', $id)->get();

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

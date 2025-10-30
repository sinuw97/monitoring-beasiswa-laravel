<?php

namespace App\Http\Controllers\mahasiswa\laporan;

use App\Http\Controllers\Controller;
use App\Models\monev\LaporanMonevMahasiswa;
use Illuminate\Support\Facades\Auth;

class DetailLaporanMonevController extends Controller
{
    // Untuk nampilin halaman Detail
    public function showHalamanDetailLaporan(string $laporanId) {
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
        ]));
    }
}

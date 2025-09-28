<?php

namespace App\Http\Controllers\mahasiswa\monev;

use App\Models\monev\AcademicActivities;
use App\Models\monev\AcademicReports;
use App\Http\Controllers\Controller;
use App\Models\monev\CommitteeActivities;
use App\Models\monev\Evaluations;
use App\Models\monev\IndependentActivities;
use App\Models\monev\OrganizationActivities;
use App\Models\monev\StudentAchievements;
use App\Models\monev\TargetAcademicActivities;
use App\Models\monev\TargetAchievements;
use App\Models\monev\TargetIdependentActivities;
use App\Models\monev\TargetNextSemester;
use Illuminate\Http\Request;

class HapusDataMonevController extends Controller
{
    public function hapusDataAcademicReport($idData) {
        // cek
        $cekData = AcademicReports::findOrFail($idData);
        $cekData->delete();

        return redirect()->back()->with('success', 'Data nilai IPK dan IPS berhasil dihapus!');
    }

    public function hapusDataAcademicActivities($idData) {
        // cek
        $cekData = AcademicActivities::findOrFail($idData);
        $cekData->delete();

        return redirect()->back()->with('success', 'Data kegiatan akademic berhasil dihapus!');
    }

    public function hapusDataOrganizationActivities($idData) {
        // cek
        $cekData = OrganizationActivities::findOrFail($idData);
        $cekData->delete();

        return redirect()->back()->with('success', 'Data kegiatan organisasi berhasil dihapus');
    }

    public function hapusDataCommitteeActivities($idData) {
        // cek
        $cekData = CommitteeActivities::findOrFail($idData);
        $cekData->delete();

        return redirect()->back()->with('success', 'Data kegiatan komite atau penugasan berhasil dihapus!');
    }

    public function hapusDataAchievement($idData) {
        // cek
        $cekData = StudentAchievements::findOrFail($idData);
        $cekData->delete();

        return redirect()->back()->with('success', 'Data prestasi mahasiswa berhasil dihapus!');
    }

    public function hapusDataIndependentActivities($idData) {
        //cek
        $cekData = IndependentActivities::findOrFail($idData);
        $cekData->delete();

        return redirect()->back()->with('success', 'Data prestasi mahasiswa berhasil dihapus!');
    }

    public function hapusDataEvaluasi($idData){
        //cek
        $cekData = Evaluations::findOrFail($idData);
        $cekData->delete();

        return redirect()->back()->with('success', 'Data evaluasi berhasil dihapus!');
    }

    public function hapusDataNextReport($idData) {
        //cek
        $cekData = TargetNextSemester::findOrFail($idData);
        $cekData->delete();

        return redirect()->back()->with('success', 'Data nilai IPS dan IPK semester depan berhasil dihapus');
    }

    public function hapusDataNextActivities($idData) {
        //cek
        $cekData = TargetAcademicActivities::findOrFail($idData);
        $cekData->delete();

        return redirect()->back()->with('success', 'Data rencana kegiatan akademik berhasil dihapus!');
    }

    public function hapusDataNextAchievement($idData) {
        //cek
        $cekData = TargetAchievements::findOrFail($idData);
        $cekData->delete();

        return redirect()->back()->with('success', 'Data rencana prestasi berhasil dihapus!');
    }

    public function hapusDataNextIndependent($idData) {
        //cek
        $cekData = TargetIdependentActivities::findOrFail($idData);
        $cekData->delete();

        return redirect()->back()->with('success', 'Data rencana kegiatan independen berhasil dihapus!');
    }
}

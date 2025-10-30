<?php

namespace App\Http\Controllers\mahasiswa\monev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\monev\TargetAchievements;

class TargetAchievementsMonevController extends Controller
{
  // SUbmit Data
  public function submitTargetAchievements(Request $request, string $laporanId)
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
  // Edit Data
  public function updateTargetAchievements(Request $request, string $idData)
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
  // hapus Data
  public function hapusDataNextAchievement(string $idData)
  {
    //cek
    $cekData = TargetAchievements::findOrFail($idData);
    $cekData->delete();

    return redirect()->back()->with('success', 'Data rencana prestasi berhasil dihapus!');
  }
}

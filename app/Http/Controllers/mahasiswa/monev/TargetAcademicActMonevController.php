<?php

namespace App\Http\Controllers\mahasiswa\monev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\monev\TargetAcademicActivities;

class TargetAcademicActMonevController extends Controller
{
  // SUbmit Data
  public function submitTargetKegAkademik(Request $request, string $laporanId)
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
  // EDit DATa
  public function updateTargetKegAkademik(Request $request, string $idData)
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
  // Hapus Data
  public function hapusDataNextActivities(string $idData)
  {
    //cek
    $cekData = TargetAcademicActivities::findOrFail($idData);
    $cekData->delete();

    return redirect()->back()->with('success', 'Data rencana kegiatan akademik berhasil dihapus!');
  }
}

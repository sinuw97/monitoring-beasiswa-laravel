<?php

namespace App\Http\Controllers\mahasiswa\monev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\monev\TargetIdependentActivities;

class TargetIndeActMonevController extends Controller
{
  // Submit Data
  public function submitTargetKegMandiri(Request $request, string $laporanId)
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
  // Edit Data
  public function updateTargetKegMandiri(Request $request, string $idData)
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
  // Hapus Data
  public function hapusDataNextIndependent(string $idData)
  {
    //cek
    $cekData = TargetIdependentActivities::findOrFail($idData);
    $cekData->delete();

    return redirect()->back()->with('success', 'Data rencana kegiatan independen berhasil dihapus!');
  }
}

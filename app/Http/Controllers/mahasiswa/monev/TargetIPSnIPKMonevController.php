<?php

namespace App\Http\Controllers\mahasiswa\monev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\monev\TargetNextSemester;

class TargetIPSnIPKMonevController extends Controller
{
  // Sumbit Data
  public function submitTargetIPSnIPK(Request $request, string $laporanId)
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
  // Edit Data
  public function updateTargetIPSnIPK(Request $request, string $idData)
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
  // Hapus Data
  public function hapusDataNextReport(string $idData)
  {
    //cek
    $cekData = TargetNextSemester::findOrFail($idData);
    $cekData->delete();

    return redirect()->back()->with('success', 'Data nilai IPS dan IPK semester depan berhasil dihapus');
  }
}

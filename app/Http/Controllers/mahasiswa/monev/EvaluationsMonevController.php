<?php

namespace App\Http\Controllers\mahasiswa\monev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\monev\Evaluations;


class EvaluationsMonevController extends Controller
{
  // SUbmit Data
  public function submitEvaluasi(Request $request, string $laporanId)
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
  // Edit Data
  public function updateEvaluasi(Request $request, string $idData)
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
  // Hapus Data
  public function hapusDataEvaluasi(string $idData)
  {
    //cek
    $cekData = Evaluations::findOrFail($idData);
    $cekData->delete();

    return redirect()->back()->with('success', 'Data evaluasi berhasil dihapus!');
  }
}

<?php

namespace App\Http\Controllers\mahasiswa\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\monev\LaporanMonevMahasiswa;
use App\Models\users\Mahasiswa;
use Illuminate\Support\Facades\Auth;

class DashboardMahasiswaController extends Controller
{
    public function showDashboard() {
      // ambil data mhs yg login
      $mahasiswa = Auth::guard('mahasiswa')->user();

      // ambil data di tabel mahasiswa dan detail
      $dataMahasiswa = Mahasiswa::with('detailMahasiswa')
        ->where('nim', $mahasiswa->nim)
        ->first();

      $dataMahasiswa->makeHidden(['password']);

      // AMbil semua laporan
      $allLaporan = LaporanMonevMahasiswa::where('nim', $mahasiswa->nim)
          ->whereIn('status', ['Draft', 'Pending'])
          ->get();

      // saring laporan yg status = Draft
      $draftedLaporan = $allLaporan->where('status', 'Draft');

      // saring laporan yg status = Pending
      $pendingLaporan = $allLaporan->where('status', 'Pending');

      return view('mahasiswa.dashboard', compact('dataMahasiswa', 'draftedLaporan', 'pendingLaporan'));
    }
}

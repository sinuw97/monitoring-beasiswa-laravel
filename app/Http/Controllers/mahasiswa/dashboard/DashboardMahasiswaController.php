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

      // ambil laporan yang masih Draft
      $draftedLaporan = LaporanMonevMahasiswa::with('periodeSemester')
      ->where('nim', $dataMahasiswa->nim)
      ->where('status', 'Draft')
      ->orderBy('created_at', 'desc')
      ->get();

      return view('mahasiswa.dashboard', compact('dataMahasiswa', 'draftedLaporan'));
    }
}

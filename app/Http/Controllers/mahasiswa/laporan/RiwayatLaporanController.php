<?php

namespace App\Http\Controllers\mahasiswa\laporan;

use App\Http\Controllers\Controller;
use App\Models\monev\LaporanMonevMahasiswa;
use App\Models\users\Mahasiswa;
use Illuminate\Support\Facades\Auth;

class RiwayatLaporanController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Ambil data mahasiswa (buat navbar/avatar)
        $dataMahasiswa = Mahasiswa::with('detailMahasiswa')
            ->where('nim', $mahasiswa->nim)
            ->first();

        // Ambil semua laporan yang bukan draft (laporan terkirim)
        $riwayatLaporan = LaporanMonevMahasiswa::with('periodeSemester')
            ->where('nim', $mahasiswa->nim)
            ->where('status', '!=', 'Draft')
            ->orderBy('semester', 'asc')
            ->get();

        return view('mahasiswa.riwayat-laporan', compact('dataMahasiswa', 'riwayatLaporan'));
    }
}

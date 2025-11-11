<?php

namespace App\Http\Controllers\mahasiswa\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\monev\LaporanMonevMahasiswa;
use App\Models\users\Mahasiswa;
use Illuminate\Support\Facades\Auth;

class DashboardMahasiswaController extends Controller
{
    public function showDashboard()
    {
        // Ambil data mahasiswa yang login
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Ambil data lengkap mahasiswa beserta detail
        $dataMahasiswa = Mahasiswa::with('detailMahasiswa')
            ->where('nim', $mahasiswa->nim)
            ->first();

        $dataMahasiswa->makeHidden(['password']);

        // Ambil semua laporan
        $allLaporan = LaporanMonevMahasiswa::where('nim', $mahasiswa->nim)
            ->whereIn('status', ['Draft', 'Pending', 'Lolos', 'Rejected', 'Ditolak SP-1'])
            ->get();

        // Pisahkan laporan berdasarkan status
        $draftedLaporan = $allLaporan->where('status', 'Draft');
        $pendingLaporan = $allLaporan->where('status', 'Pending');
        $lolosLaporan = $allLaporan->where('status', 'Lolos');

        // jmlh laporan yg harus mhs kirim
        $prodi = $dataMahasiswa->detailMahasiswa->prodi;
        $totalLaporan = str_contains($prodi, 'S1') ? 8 : 6;

        // jmlh laporan yg sudah dikirim mhs
        $jumlahLaporanTerkirim = $allLaporan->where('status', '!=', 'Draft')->count();
        $presentaseLaporan = ($jumlahLaporanTerkirim / $totalLaporan) * 100;

        // Kirim data ke view
        return view('mahasiswa.dashboard', compact(
            'dataMahasiswa',
            'draftedLaporan',
            'lolosLaporan',
            'pendingLaporan',
            'totalLaporan',
            'jumlahLaporanTerkirim',
            'presentaseLaporan'
        ));
    }
}

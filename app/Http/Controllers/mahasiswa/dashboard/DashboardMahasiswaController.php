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

        // Progress bar dengan total target 8 laporan
        $totalTargetLaporan = 8; // jumlah laporan maksimal
        $laporanValid = $allLaporan->whereIn('status', ['Lolos'])->count(); // dihitung sudah dikirim/valid
        $persentaseLaporan = ($laporanValid / $totalTargetLaporan) * 100;

        // Kirim data ke view
        return view('mahasiswa.dashboard', compact(
            'dataMahasiswa',
            'draftedLaporan',
            'lolosLaporan',
            'pendingLaporan',
            'laporanValid',
            'totalTargetLaporan',
            'persentaseLaporan'
        ));
    }
}

<?php

namespace App\Http\Controllers\mahasiswa\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\monev\LaporanMonevMahasiswa;
use App\Models\semester\Periode;
use App\Models\users\Mahasiswa;
use Illuminate\Support\Facades\Auth;

class DashboardMahasiswaController extends Controller
{
    public function showDashboard()
    {
        // Ambil data mahasiswa yang login
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if (!$mahasiswa) {
            abort(401, 'User belum login!');
        }

        // Ambil data lengkap mahasiswa beserta detail
        $dataMahasiswa = Mahasiswa::with('detailMahasiswa')
            ->where('nim', $mahasiswa->nim)
            ->first();

        $dataMahasiswa->makeHidden(['password']);

        // Ambil semua laporan
        $allLaporan = LaporanMonevMahasiswa::where('nim', $mahasiswa->nim)
            ->get();

        // Pisahkan laporan berdasarkan status
        $draftedLaporan = $allLaporan->where('status', 'Draft');
        $pendingLaporan = $allLaporan->where('status', 'Pending');
        $laporanDikembalikan = $allLaporan->where('status', 'Dikembalikan');
        $laporanLolos = $allLaporan->where('status', 'Lolos');

        // jmlh laporan yg harus mhs kirim
        $prodi = $dataMahasiswa->detailMahasiswa->prodi;
        $totalLaporan = str_contains($prodi, 'S1') ? 8 : 6;

        // jmlh laporan yg sudah dikirim mhs
        $jumlahLaporanTerkirim = $allLaporan->where('status', '!=', 'Draft')->count();
        $presentaseLaporan = ($jumlahLaporanTerkirim / $totalLaporan) * 100;

        // ambil periode yang Aktif utk fitampilkan ke running text
        $periodeAktif = Periode::where('status', 'Aktif')
            ->first();

        if ($periodeAktif) {
            $pengumuman = "Pengumuman: Periode {$periodeAktif->tahun_akademik} - {$periodeAktif->semester} telah dibuka! Segera lengkapi laporan monev Anda sebelum periode ditutup!";
        } else {
            $pengumuman = "Saat ini belum ada periode monev yang aktif. Silakan tunggu pengumuman selanjutnya. Terimakasih.";
        }
        // Kirim data ke view
        return view('mahasiswa.dashboard', compact(
            'dataMahasiswa',
            'draftedLaporan',
            'pengumuman',
            'laporanLolos',
            'pendingLaporan',
            'laporanDikembalikan',
            'totalLaporan',
            'jumlahLaporanTerkirim',
            'presentaseLaporan'
        ));
    }
}

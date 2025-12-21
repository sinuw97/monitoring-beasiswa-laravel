<?php

namespace App\Http\Controllers\mahasiswa\profile;

use App\Http\Controllers\Controller;
use App\Models\monev\LaporanMonevMahasiswa;
use App\Models\users\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilMahasiswaController extends Controller
{
    public function show()
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user()->load('detailMahasiswa');

        // Ambil data lengkap mahasiswa beserta detail
        $dataMahasiswa = Mahasiswa::with('detailMahasiswa')
            ->where('nim', $dataMahasiswa->nim)
            ->first();

        $dataMahasiswa->makeHidden(['password']);

        // Ambil semua laporan
        $allLaporan = LaporanMonevMahasiswa::where('nim', $dataMahasiswa->nim)
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

        return view('mahasiswa.profile', compact(
            'dataMahasiswa',
            'totalLaporan',
            'jumlahLaporanTerkirim',
            'presentaseLaporan'
        ));
    }

    public function edit()
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user()->load('detailMahasiswa');

        // Ambil data lengkap mahasiswa beserta detail
        $dataMahasiswa = Mahasiswa::with('detailMahasiswa')
            ->where('nim', $dataMahasiswa->nim)
            ->first();

        $dataMahasiswa->makeHidden(['password']);

        // Ambil semua laporan
        $allLaporan = LaporanMonevMahasiswa::where('nim', $dataMahasiswa->nim)
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

        return view('mahasiswa.edit-profile', compact(
            'dataMahasiswa',
            'totalLaporan',
            'jumlahLaporanTerkirim',
            'presentaseLaporan'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
        ]);

        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Update kolom di tabel mahasiswa (misalnya email)
        $mahasiswa->email = $request->email;
        $mahasiswa->save();

        // Update kolom di tabel detail_mahasiswa (no_hp, alamat)
        if ($mahasiswa->detailMahasiswa) {
            $mahasiswa->detailMahasiswa->update([
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        }

        return redirect()->route('mahasiswa.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}

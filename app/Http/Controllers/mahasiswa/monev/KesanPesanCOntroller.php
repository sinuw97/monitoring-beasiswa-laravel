<?php

namespace App\Http\Controllers\mahasiswa\monev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\monev\KesanPesanMahasiswa;
use Illuminate\Support\Facades\Auth;

class KesanPesanCOntroller extends Controller
{
    // submit data
    public function submitKesanPesan(Request $request, $laporanId){
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'kesan' => 'required|string|min:1',
            'pesan' => 'required|string|min:1',
        ]);

        KesanPesanMahasiswa::create([
            'laporan_id' => $laporanId,
            'nim' => $dataMahasiswa->nim,
            'kesan' => $validated['kesan'],
            'pesan' => $validated['pesan'],
            'status' => 'Draft'
        ]);

        return back()->with('success', 'Data Kesan dan Pesan berhasil ditambah!');
    }

    // edit data
    public function updateKesanPesan(Request $request, string $idData){
        $report = KesanPesanMahasiswa::findOrFail($idData);

        $validated = $request->validate([
            'kesan' => 'required|string|min:1',
            'pesan' => 'required|string|min:1',
        ]);

        $report->kesan = $validated['kesan'];
        $report->pesan = $validated['pesan'];
        $report->save();

        return back()->with('success', 'Data Kesan dan Pesan berhasil diupdate!');
    }

    // hapus data
    public function hapusKesanPesan(string $idData){
        $cekData = KesanPesanMahasiswa::findOrFail($idData);
        $cekData->delete();

        return back()->with('success', 'Data Kesan dan Pesan berhasil dihapus!');
    }
}

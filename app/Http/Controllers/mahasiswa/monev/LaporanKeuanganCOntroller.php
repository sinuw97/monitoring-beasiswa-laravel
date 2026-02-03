<?php

namespace App\Http\Controllers\mahasiswa\monev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\monev\LaporanKeuanganMahasiswa;
use App\Models\monev\DetailKeuanganMahasiswa;

class LaporanKeuanganCOntroller extends Controller
{
    // submit data
    public function submitLaporanKeuangan(Request $request, $laporanId)
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'keperluan' => 'required|string|min:1',
            'nominal' => 'required|numeric|min:1',
        ]);

        // buat atau ambil data di laporan_keuangan_mahasiswa (induk)
        DB::transaction(function () use ($validated, $laporanId, $dataMahasiswa) {
            // ambil atau buat laporan keuangan (INDUK)
            $laporanKeuangan = LaporanKeuanganMahasiswa::firstOrCreate(
                [
                    'laporan_id' => $laporanId,
                    'nim' => $dataMahasiswa->nim,
                ],
                [
                    'total_nominal' => 0,
                    'status' => 'draft',
                ]
            );

            // simpan detail keuangan
            DetailKeuanganMahasiswa::create([
                'laporan_keuangan_id' => $laporanKeuangan->id,
                'nim' => $dataMahasiswa->nim,
                'keperluan' => $validated['keperluan'],
                'nominal' => $validated['nominal'],
                'status' => 'draft',
            ]);

            // update total nominal (TAMBAH)
            $laporanKeuangan->increment('total_nominal', $validated['nominal']);
        });

        return back()->with('success', 'Data keuangan berhasil ditambahkan');
    }

    // edit data
    public function updateLaporanKeuangan(Request $request, string $idData) {
        $validated = $request->validate([
            'keperluan' => 'required|string|min:1',
            'nominal' => 'required|numeric|min:1',
        ]);

        DB::transaction(function () use ($validated, $idData) {
            $detail = DetailKeuanganMahasiswa::findOrFail($idData);
            $laporanKeuangan = $detail->laporanKeuanganMahasiswa;

            $nominalLama = $detail->nominal;
            $nominalBaru = $validated['nominal'];

            // update detail
            $detail->update([
                'keperluan' => $validated['keperluan'],
                'nominal' => $nominalBaru,
            ]);

            // update total induk (SELISIH)
            $selisih = $nominalBaru - $nominalLama;
            $laporanKeuangan->increment('total_nominal', $selisih);
        });

        return back()->with('success', value: 'Data keuangan berhasil diperbarui');
    }

    // hapus data
    public function hapusLaporanKeuangan(string $idData) {
        DB::transaction(function () use ($idData) {

            $detail = DetailKeuanganMahasiswa::findOrFail($idData);
            $laporanKeuangan = $detail->laporanKeuanganMahasiswa;

            // kurangi total induk
            $laporanKeuangan->decrement('total_nominal', $detail->nominal);

            // hapus detail
            $detail->delete();
        });

        return back()->with('success', 'Detail keuangan berhasil dihapus');
    }
}

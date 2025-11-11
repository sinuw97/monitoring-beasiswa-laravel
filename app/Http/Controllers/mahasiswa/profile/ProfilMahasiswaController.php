<?php

namespace App\Http\Controllers\mahasiswa\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilMahasiswaController extends Controller
{
    public function show()
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user()->load('detailMahasiswa');
        return view('mahasiswa.profile', compact('dataMahasiswa'));
    }

    public function edit()
    {
        $dataMahasiswa = Auth::guard('mahasiswa')->user()->load('detailMahasiswa');
        return view('mahasiswa.edit-profile', compact('dataMahasiswa'));
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

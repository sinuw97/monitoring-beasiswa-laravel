<?php

namespace App\Http\Controllers\mahasiswa\monev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PengisianMonevController extends Controller
{
    public function showHalaman()
    {
        // ambil data mhs yg login
        $dataMahasiswa = Auth::guard('mahasiswa')->user();

        return view('mahasiswa.halaman-pengisian-laporan', compact('dataMahasiswa'));
    }
}

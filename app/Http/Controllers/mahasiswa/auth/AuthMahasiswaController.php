<?php

namespace App\Http\Controllers\mahasiswa\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\users\DetailMahasiswa;
use App\Models\users\Mahasiswa;
use Illuminate\Support\Facades\Auth;

class AuthMahasiswaController extends Controller
{
    public function showLogin()
    {
        return view('mahasiswa.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'nim' => 'required|string',
            'password' => 'required|string',
        ]);

        // cek status mahasiswa dulu
        $mahasiswaAktif = DetailMahasiswa::where('nim', $request->nim)
            ->where('status', 'Aktif')
            ->exists();

        if (!$mahasiswaAktif) {
            return back()->withErrors([
                'status' => 'Akun sudah tidak aktif'
            ]);
        }

        if (Auth::guard('mahasiswa')->attempt($request->only('nim', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('/mahasiswa/dashboard');
        }

        return back()->withErrors([
            'nim' => 'NIM atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('mahasiswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/mahasiswa/login');
    }
}

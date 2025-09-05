<?php

namespace App\Http\Controllers\mahasiswa\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthMahasiswaController extends Controller
{
    public function showLogin() {
        return view('mahasiswa.login');
    }
    public function login(Request $request) {
        $request->validate([
            'nim' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('mahasiswa')->attempt($request->only('nim', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('/mahasiswa/dashboard');
        }

        return back()->withErrors([
            'nim' => 'nim atau password salah.',
        ]);
    }
    public function logout(Request $request) {
        Auth::guard('mahasiswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/mahasiswa/login');
    }
}

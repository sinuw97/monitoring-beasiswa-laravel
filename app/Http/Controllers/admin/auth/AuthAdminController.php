<?php

namespace App\Http\Controllers\admin\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthAdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('admin/login');
        }

        return back()->withErrors([
            'email' => 'email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('admin/login');
    }
}

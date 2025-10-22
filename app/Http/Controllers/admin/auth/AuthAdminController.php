<?php

namespace App\Http\Controllers\admin\auth;

use App\Models\users\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthAdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function showRegister(){
        return view('admin.register');
    }

    public function register(Request $request){
        $request->validate([
            'user_id'=>'required|string|unique:admin,user_id',
            'name'=>'required|string',
            'email'=>'required|string',
            'password'=>'required|string',
            'avatar'=>'required|string',
        ]);

        Admin::create([
            'user_id'=>$request->user_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'avatar'=>$request->avatar,
        ]);

        return redirect('admin/login')->with('success','Akun berhasil dibuat, silahkan login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
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

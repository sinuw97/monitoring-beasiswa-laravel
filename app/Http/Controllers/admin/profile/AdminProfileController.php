<?php

namespace App\Http\Controllers\admin\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function edit()
    {
        $dataAdmin = Auth::guard('admin')->user();
        return view('admin.profile', compact('dataAdmin'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:admin,email,' . Auth::guard('admin')->id() . ',user_id',
            'name' => 'required|string|max:255',
        ]);

        $dataAdmin = Auth::guard('admin')->user();
        $dataAdmin->name = $request->name;
        $dataAdmin->email = $request->email;
        $dataAdmin->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    public function verifyPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'min:8',
                'regex:/[0-9]/',
                'regex:/[\W_]/',
            ],
            'confirm_password' => 'required|same:new_password',
        ], [
            'new_password.regex' => 'Password harus mengandung minimal 1 angka dan 1 simbol.',
            'new_password.min'   => 'Password minimal 8 karakter.',
            'confirm_password.same' => 'Konfirmasi password tidak cocok.',
        ]);

        $dataAdmin = Auth::guard('admin')->user();

        if (!Hash::check($request->current_password, $dataAdmin->password)) {
            return back()
                ->withInput()
                ->with('error', 'Password saat ini salah.');
        }

        if ($request->current_password === $request->new_password) {
            return back()->withInput()->with('ganti_pw_error', 'Password baru tidak boleh sama dengan password lama');
        }

        $dataAdmin->password = Hash::make($request->new_password);
        $dataAdmin->save();

        Auth::guard('admin')->login($dataAdmin);

        return back()->with('ganti_pw_success', 'Password berhasil diubah');
    }
}

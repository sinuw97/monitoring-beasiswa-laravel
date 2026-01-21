<?php

namespace App\Http\Controllers\mahasiswa\profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GantiPasswordController extends Controller
{
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
        ], [
            'new_password.regex' => 'Password harus mengandung minimal 1 angka dan 1 simbol.',
            'new_password.min'   => 'Password minimal 8 karakter.',
        ]);

        // dapetin data mhs login
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if (!Hash::check($request->current_password, $mahasiswa->password)) {
            return back()
                ->withInput()
                ->with('error', 'Password saat ini salah.');
        }

        if ($request->current_password === $request->new_password) {
            return back()->withInput()->with('ganti_pw_error', 'Password lama salah');
        }

        $mahasiswa->password = Hash::make($request->new_password);
        $mahasiswa->save();

        // refresh auth session
        Auth::guard('mahasiswa')->login($mahasiswa);

        return back()->with('ganti_pw_success', 'Password berhasil diubah');
    }
}

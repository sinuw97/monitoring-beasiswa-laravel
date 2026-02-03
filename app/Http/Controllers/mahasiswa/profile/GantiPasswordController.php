<?php

namespace App\Http\Controllers\mahasiswa\profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class GantiPasswordController extends Controller
{
    public function verifyPassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => [
                    'required',
                    'min:8',
                    'regex:/[0-9]/',
                    'regex:/[\W_]/',
                ],
            ], [
                'current_password.required' => 'Password saat ini wajib diisi.',
                'new_password.required'     => 'Password baru wajib diisi.',
                'new_password.min'          => 'Password minimal 8 karakter.',
                'new_password.regex'        => 'Password harus mengandung minimal 1 angka dan 1 simbol.',
            ]);
        } catch (ValidationException $e) {

            return back()
                ->withErrors($e->validator, 'gantiPassword')
                ->withInput()
                ->with('ganti_pw_error', true);
        }

        $mahasiswa = Auth::guard('mahasiswa')->user();

        // cek password lama
        if (!Hash::check($request->current_password, $mahasiswa->password)) {
            return back()
                ->withErrors([
                    'current_password' => 'Password saat ini salah.',
                ], 'gantiPassword')
                ->withInput()
                ->with('ganti_pw_error', true);
        }

        // cegah password sama
        if ($request->current_password === $request->new_password) {
            return back()
                ->withErrors([
                    'new_password' => 'Password baru tidak boleh sama dengan password lama.',
                ], 'gantiPassword')
                ->withInput()
                ->with('ganti_pw_error', true);
        }

        // update password
        $mahasiswa->password = Hash::make($request->new_password);
        $mahasiswa->save();

        // refresh session
        Auth::guard('mahasiswa')->login($mahasiswa);

        return back()->with('ganti_pw_success', true);
    }
}

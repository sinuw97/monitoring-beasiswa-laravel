<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\users\Admin;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $dataAdmin = Admin::where('email', $admin->email)
            ->where('user_id', $admin->user_id)
            ->first();

        $dataAdmin->makeHidden(['password']);
        $pengumuman = Pengumuman::latest()->paginate(10);
        return view('admin.pengumuman.index', compact('pengumuman', 'dataAdmin'));
    }

    public function create()
    {
        $admin = Auth::guard('admin')->user();
        $dataAdmin = Admin::where('email', $admin->email)
            ->where('user_id', $admin->user_id)
            ->first();

        $dataAdmin->makeHidden(['password']);
        return view('admin.pengumuman.create', compact('dataAdmin'));
    }

    public function store(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $dataAdmin = Admin::where('email', $admin->email)
            ->where('user_id', $admin->user_id)
            ->first();

        $dataAdmin->makeHidden(['password']);
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'is_active' => 'boolean',
        ]);

        Pengumuman::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        $admin = Auth::guard('admin')->user();
        $dataAdmin = Admin::where('email', $admin->email)
            ->where('user_id', $admin->user_id)
            ->first();

        $dataAdmin->makeHidden(['password']);
        return view('admin.pengumuman.edit', compact('pengumuman', 'dataAdmin'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $admin = Auth::guard('admin')->user();
        $dataAdmin = Admin::where('email', $admin->email)
            ->where('user_id', $admin->user_id)
            ->first();

        $dataAdmin->makeHidden(['password']);
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $pengumuman->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'is_active' => $request->has('is_active'), // Checkbox handling
        ]);

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}

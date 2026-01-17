<?php

namespace App\Http\Controllers\admin\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\users\Admin;
use App\Models\users\DetailMahasiswa;
use App\Models\users\Mahasiswa;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DataMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index(Request $request)
{
    // Ambil data admin yang sedang login
    $admin = Auth::guard('admin')->user();

    $dataAdmin = Admin::where('email', $admin->email)
        ->where('user_id', $admin->user_id)
        ->first();

    $dataAdmin->makeHidden(['password']);

    // --- QUERY DASAR UNTUK DATA MAHASISWA ---
    $query = Mahasiswa::query();

    // --- AMBIL DAFTAR ANGKATAN (2 DIGIT PERTAMA NIM) ---
    $angkatanList = Mahasiswa::selectRaw('LEFT(nim, 2) as angkatan')
        ->distinct()
        ->pluck('angkatan');

    // --- FILTER ANGKATAN JIKA ADA REQUEST ---
    if ($request->filled('angkatan')) {
        $angkatan = $request->angkatan;
        $query->whereRaw('LEFT(nim, 2) = ?', [$angkatan]);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('nim', 'LIKE', "%{$search}%");
        });
    }

    // --- SORTING NAMA JIKA ADA REQUEST ---
    if ($request->sort === 'asc') {
        $query->orderBy('name', 'asc');
    } elseif ($request->sort === 'desc') {
        $query->orderBy('name', 'desc');
    } else {
        // Default: urut berdasarkan NIM
        $query->orderBy('nim', 'asc');
    }

    // --- PAGINATION ---
    $dataMahasiswa = $query->paginate(50);

    // Kembalikan ke view dengan semua data
    return view('admin.data-mahasiswa.index', [
        'dataAdmin' => $dataAdmin,
        'dataMahasiswa' => $dataMahasiswa,
        'angkatanList' => $angkatanList,
    ]);
}


    /**
     * Export data to Excel.
     */
    public function export(Request $request)
    {
        // --- QUERY DASAR UNTUK DATA MAHASISWA ---
        $query = Mahasiswa::query();

        // --- FILTER ANGKATAN JIKA ADA REQUEST ---
        if ($request->filled('angkatan')) {
            $angkatan = $request->angkatan;
            $query->whereRaw('LEFT(nim, 2) = ?', [$angkatan]);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('nim', 'LIKE', "%{$search}%");
            });
        }

        // --- SORTING NAMA JIKA ADA REQUEST ---
        if ($request->sort === 'asc') {
            $query->orderBy('name', 'asc');
        } elseif ($request->sort === 'desc') {
            $query->orderBy('name', 'desc');
        } else {
            // Default: urut berdasarkan NIM
            $query->orderBy('nim', 'asc');
        }

        // --- AMBIL DATA (GET) BUKAN PAGINATE ---
        $dataMahasiswa = $query->get();

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\DataMahasiswaExport($dataMahasiswa), 'data_mahasiswa_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            Mahasiswa::create([
                'avatar' => 'https://ui-avatars.com/api/?name='.str_replace(' ', '+', $request->name),
                'name' => $request->name,
                'email' => $request->email,
                'nim' => $request->nim,
                'angkatan' => '20'.$request->angkatan,
                'password' => bcrypt($request->nim),
            ]);

            DetailMahasiswa::create([
                'nim' => $request->nim,
                'prodi' => $request->prodi,
                'kelas' => $request->kelas,
                'no_hp' => $request->no_hp,
                'jenis_beasiswa' => $request->jenis_beasiswa,
                'jenis_kelamin' => $request->jenis_kelamin,
                'angkatan' => '20'.$request->angkatan,
                'status' => $request->status,
                'alamat' => $request->alamat
            ]);

            return redirect('/admin/data-mahasiswa')->with('success', 'Data mahasiswa berhasil ditambahkan.');
        }catch(Exception $e){
            return redirect('/admin/data-mahasiswa')->with('error', 'Gagal menambahkan data mahasiswa.');
        }

    }

    /**
     * Import data from Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\DataMahasiswaImport, $request->file('file'));
            return redirect('/admin/data-mahasiswa')->with('success', 'Data mahasiswa berhasil diimport via Excel.');
        } catch (Exception $e) {
            return redirect('/admin/data-mahasiswa')->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel for import.
     */
    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\TemplateMahasiswaExport, 'template_mahasiswa.xlsx');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $admin = Auth::guard('admin')->user();

        $dataAdmin = Admin::where('email', $admin->email)
            ->where('user_id', $admin->user_id)
            ->first();

        $dataAdmin->makeHidden(['password']);

        $dataMahasiswa = Mahasiswa::join('detail_mahasiswa', 'mahasiswa.nim', '=', 'detail_mahasiswa.nim')->select('detail_mahasiswa.*', 'mahasiswa.*')->where('mahasiswa.nim', '=', $id)->first();

        if(!$dataMahasiswa){
            $dataMahasiswa = Mahasiswa::where('mahasiswa.nim', '=', $id)->first();
        }

        return view('admin.data-mahasiswa.edit', ['dataMahasiswa' => $dataMahasiswa, 'dataAdmin' => $dataAdmin]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'nim' => 'required|string|max:8',
            'prodi' => 'required|string|max:255',
            'angkatan' => 'required|string|max:255',
            'jenis_beasiswa' => 'string|max:100',
            'jenis_kelamin' => 'string',
            'status' => 'string',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
        ]);

        $mahasiswa = Mahasiswa::where('nim', '=', $id)->first();

        // Update kolom di tabel mahasiswa (misalnya email)
        $mahasiswa->name = $request->name;
        $mahasiswa->nim = $request->nim;
        $mahasiswa->email = $request->email;
        $mahasiswa->save();

        // Update kolom di tabel detail_mahasiswa (no_hp, alamat)
        if ($mahasiswa->detailMahasiswa) {
            $mahasiswa->detailMahasiswa->update([
                'prodi' => $request->prodi,
                'angkatan' => $request->angkatan,
                'kelas' => $request->kelas,
                'jenis_kelamin' => $request->jenis_kelamin,
                'jenis_beasiswa' => $request->jenis_beasiswa,
                'status' => $request->status,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        }

        return redirect('/admin/data-mahasiswa/edit/'.$id)->with('success', 'Profil berhasil diperbarui!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $mahasiswa = Mahasiswa::findOrFail($id);
        $detailMahasiswa = DetailMahasiswa::where('nim', $mahasiswa->nim)->first();

        if ($detailMahasiswa) {
            $detailMahasiswa->delete();
        }

        $mahasiswa->delete();

        return redirect()->route('admin.data-mahasiswa')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}

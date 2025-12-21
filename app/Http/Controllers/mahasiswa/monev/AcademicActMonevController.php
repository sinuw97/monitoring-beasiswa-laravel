<?php

namespace App\Http\Controllers\mahasiswa\monev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\monev\AcademicActivities;
use App\Models\monev\LaporanMonevMahasiswa;
use App\Models\semester\Periode;
use App\Services\GoogleDriveService;

use Carbon\Carbon;

class AcademicActMonevController extends Controller
{
  // SUbmit Data
  public function submitKegAKademik(Request $request, string $laporanId)
  {
    $dataMahasiswa = Auth::guard('mahasiswa')->user();

    $validated = $request->validate([
      'nama-kegiatan' => 'required|string|min:1|max:255',
      'tipe-kegiatan' => 'required|string|min:1|max:255',
      'keikutsertaan' => 'required|string|min:1|max:100',
      'tempat' => 'required|string|min:1|max:255',
      'tanggal-mulai' => 'required|date',
      'tanggal-selesai' => 'required|date|after_or_equal:tanggal-mulai',
      'bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    // Pengecekan apakah tanggal mulai dan selesai masih dalam satu periode?
    $laporan = LaporanMonevMahasiswa::findOrFail($laporanId);
    $semesterId = $laporan->semester_id;

    $periode = Periode::where('semester_id', $semesterId)->first();

    if (!$periode) {
      return back()->withErrors('Periode semester tidak ditemukan.');
    }

    $tanggalMulai = Carbon::parse($validated['tanggal-mulai']);
    $tanggalSelesai = Carbon::parse($validated['tanggal-selesai']);

    $errors = [];

    if ($tanggalMulai->lt($periode->tanggal_mulai)) {
      $errors['tanggal-mulai'] =
        'Tanggal mulai berada sebelum periode semester.';
    }

    if ($tanggalSelesai->gt($periode->tanggal_selesai)) {
      $errors['tanggal-selesai'] =
        'Tanggal selesai melewati periode semester.';
    }

    if (!empty($errors)) {
      return back()->withErrors($errors);
    }

    if ($request->hasFile('bukti')) {
      // service GDrive
      $drive = new GoogleDriveService();
      $parentFolderId = config('filesystems.disks.google.folderId');
      $nim = $dataMahasiswa->nim;
      // cek apkh folder mhs ada?
      $existingFolder = $drive->getFolderByName($nim, $parentFolderId);

      if ($existingFolder) {
        $nimFolderId = $existingFolder->id;
      } else {
        $folder = $drive->createFolder($nim, $parentFolderId);
        $nimFolderId = $folder->id;
      }

      $file = $request->file('bukti');
      $uploaded = $drive->uploadFile(
        $file->getRealPath(),
        $file->getClientOriginalName(),
        $nimFolderId
      );

      $drive->setPublicPermission($uploaded->id);
      $fileLink = $uploaded->webViewLink;
    }

    AcademicActivities::create([
      'laporan_id' => $laporanId,
      'nim'        => $dataMahasiswa->nim,
      'activity_name' => $validated['nama-kegiatan'],
      'activity_type' => $validated['tipe-kegiatan'],
      'participation' => $validated['keikutsertaan'],
      'place' => $validated['tempat'],
      'start_date' => $validated['tanggal-mulai'],
      'end_date' => $validated['tanggal-selesai'],
      'bukti_url' => $fileLink ?? 'Tidak Ada',
      'status' => 'Draft',
    ]);

    return redirect()->back()->with('success', 'Data Kegiatan Akademik berhasil ditambah!');
  }

  // Edit Data
  public function updateKegAKademik(Request $request, string $idData)
  {
    $report = AcademicActivities::findOrFail($idData);
    $dataMahasiswa = Auth::guard('mahasiswa')->user();

    $validated = $request->validate([
      'nama-kegiatan' => 'required|string|min:1|max:255',
      'tipe-kegiatan' => 'required|string|min:1|max:255',
      'keikutsertaan' => 'required|string|min:1|max:100',
      'tempat' => 'required|string|min:1|max:255',
      'tanggal-mulai' => 'required|date',
      'tanggal-selesai' => 'required|date|after_or_equal:tanggal-mulai',
      'bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    // Pengecekan apakah tanggal mulai dan selesai masih dalam satu periode?
    $laporan = LaporanMonevMahasiswa::findOrFail($report->laporan_id);
    $semesterId = $laporan->semester_id;

    $periode = Periode::where('semester_id', $semesterId)->first();

    $tanggalMulai = Carbon::parse($validated['tanggal-mulai']);
    $tanggalSelesai = Carbon::parse($validated['tanggal-selesai']);

    $errors = [];

    if ($tanggalMulai->lt($periode->tanggal_mulai)) {
      $errors['tanggal-mulai'] =
        'Tanggal mulai berada sebelum periode semester.';
    }

    if ($tanggalSelesai->gt($periode->tanggal_selesai)) {
      $errors['tanggal-selesai'] =
        'Tanggal selesai melewati periode semester.';
    }

    if (!empty($errors)) {
      return back()->withErrors($errors);
    }

    $report->activity_name = $validated['nama-kegiatan'];
    $report->activity_type = $validated['tipe-kegiatan'];
    $report->participation = $validated['keikutsertaan'];
    $report->place = $validated['tempat'];
    $report->start_date = $validated['tanggal-mulai'];
    $report->end_date = $validated['tanggal-selesai'];

    if ($request->hasFile('bukti')) {
      // service GDrive
      $drive = new GoogleDriveService();
      $parentFolderId = config('filesystems.disks.google.folderId');
      $nim = $dataMahasiswa->nim;
      // cek apkh folder mhs ada?
      $existingFolder = $drive->getFolderByName($nim, $parentFolderId);

      if ($existingFolder) {
        $nimFolderId = $existingFolder->id;
      } else {
        $folder = $drive->createFolder($nim, $parentFolderId);
        $nimFolderId = $folder->id;
      }

      $file = $request->file('bukti');
      $uploaded = $drive->uploadFile(
        $file->getRealPath(),
        $file->getClientOriginalName(),
        $nimFolderId
      );

      $drive->setPublicPermission($uploaded->id);
      $report->bukti_url = $uploaded->webViewLink;
    }

    $report->save();

    return redirect()->back()->with('success', 'Data Kegiatan Akademik berhasil diupdate');
  }

  // Hapus data
  public function hapusDataAcademicActivities(string $idData)
  {
    // cek
    $cekData = AcademicActivities::findOrFail($idData);
    $cekData->delete();

    return redirect()->back()->with('success', 'Data kegiatan akademic berhasil dihapus!');
  }
}

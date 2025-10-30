<?php

namespace App\Http\Controllers\mahasiswa\monev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\monev\StudentAchievements;

use App\Services\GoogleDriveService;

class AchievementsMonevController extends Controller
{
  // Submit Data
  public function submitAchievemnts(Request $request, string $laporanId)
  {
    $dataMahasiswa = Auth::guard('mahasiswa')->user();

    $validated = $request->validate([
      'nama-prestasi' => 'required|string|min:1|max:255',
      'tipe-prestasi' => 'required|string|min:1|max:100',
      'tingkat' => ['required', Rule::in(['Internasional', 'Nasional', 'Regional', 'Perguruan Tinggi'])],
      'raihan' => ['required', Rule::in(['Juara 1', 'Juara 2', 'Juara 3', 'Juara Harapan', 'Peserta Terpilih', 'Pembicara', 'Moderator', 'Peserta', 'Ketua', 'Anggota', 'Juri', 'Wasit', 'Pelatih'])],
      'tempat' => 'required|string|min:1|max:255',
      'tanggal-mulai' => 'required',
      'tanggal-selesai' => 'required',
      'bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

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

    StudentAchievements::create([
      'laporan_id' => $laporanId,
      'nim' => $dataMahasiswa->nim,
      'achievements_name' => $validated['nama-prestasi'],
      'achievements_type' => $validated['tipe-prestasi'],
      'level' => $validated['tingkat'],
      'award' => $validated['raihan'],
      'place' => $validated['tempat'],
      'start_date' => $validated['tanggal-mulai'],
      'end_date' => $validated['tanggal-selesai'],
      'bukti_url' => $fileLink ?? 'Tidak Ada',
      'status' => 'Draft',
    ]);

    return redirect()->back()->with('success', 'Data Prestasi Mahasiswa berhasil ditambah!');
  }
  // Edit Data
  public function updateAchievemnts(Request $request, string $idData)
  {
    $report = StudentAchievements::findOrFail($idData);
    $dataMahasiswa = Auth::guard('mahasiswa')->user();

    $validated = $request->validate([
      'nama-prestasi' => 'required|string|min:1|max:255',
      'tipe-prestasi' => 'required|string|min:1|max:100',
      'tingkat' => ['required', Rule::in(['Internasional', 'Nasional', 'Regional', 'Perguruan Tinggi'])],
      'raihan' => ['required', Rule::in(['Juara 1', 'Juara 2', 'Juara 3', 'Juara Harapan', 'Peserta Terpilih', 'Pembicara', 'Moderator', 'Peserta', 'Ketua', 'Anggota'])],
      'tempat' => 'required|string|min:1|max:255',
      'tanggal-mulai' => 'required',
      'tanggal-selesai' => 'required',
      'bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $report->achievements_name = $validated['nama-prestasi'];
    $report->achievements_type = $validated['tipe-prestasi'];
    $report->scope = $validated['kelompok-individu'];
    $report->level = $validated['tingkat'];
    $report->award = $validated['raihan'];
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

    return redirect()->back()->with('success', 'Data Prestasi berhasil diupdate');
  }
  // Hapus Data
  public function hapusDataAchievement(string $idData)
  {
    // cek
    $cekData = StudentAchievements::findOrFail($idData);
    $cekData->delete();

    return redirect()->back()->with('success', 'Data prestasi mahasiswa berhasil dihapus!');
  }
}

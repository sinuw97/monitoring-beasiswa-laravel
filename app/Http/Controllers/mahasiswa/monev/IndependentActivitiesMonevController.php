<?php

namespace App\Http\Controllers\mahasiswa\monev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\monev\IndependentActivities;

use App\Services\GoogleDriveService;

class IndependentActivitiesMonevController extends Controller
{
  // Submit Data
  public function submitKegMandiri(Request $request, string $laporanId)
  {
    $dataMahasiswa = Auth::guard('mahasiswa')->user();

    $vaalidated = $request->validate([
      'nama-kegiatan' => 'required|string|min:1|max:255',
      'tipe-kegiatan' => 'required|string|min:1|max:255',
      'keikutsertaan' => 'required|string|min:1|max:255',
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

    IndependentActivities::create([
      'laporan_id' => $laporanId,
      'nim' => $dataMahasiswa->nim,
      'activity_name' => $vaalidated['nama-kegiatan'],
      'activity_type' => $vaalidated['tipe-kegiatan'],
      'participation' => $vaalidated['keikutsertaan'],
      'place' => $vaalidated['tempat'],
      'start_date' => $vaalidated['tanggal-mulai'],
      'end_date' => $vaalidated['tanggal-selesai'],
      'bukti_url' => $fileLink ?? 'Tidak Ada',
      'status' => 'Draft',
    ]);

    return  redirect()->back()->with('success', 'Data Kegiatan Mandiri berhasil ditambahkan!');
  }
  // Edit Data
  public function updateKegMandiri(Request $request, string $idData)
  {
    $report = IndependentActivities::findOrFail($idData);
    $dataMahasiswa = Auth::guard('mahasiswa')->user();

    $vaalidated = $request->validate([
      'nama-kegiatan' => 'required|string|min:1|max:255',
      'tipe-kegiatan' => 'required|string|min:1|max:255',
      'keikutsertaan' => 'required|string|min:1|max:255',
      'tempat' => 'required|string|min:1|max:255',
      'tanggal-mulai' => 'required',
      'tanggal-selesai' => 'required',
      'bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $report->activity_name = $vaalidated['nama-kegiatan'];
    $report->activity_type = $vaalidated['tipe-kegiatan'];
    $report->participation = $vaalidated['keikutsertaan'];
    $report->place = $vaalidated['tempat'];
    $report->start_date = $vaalidated['tanggal-mulai'];
    $report->end_date = $vaalidated['tanggal-selesai'];

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

    return redirect()->back()->with('success', 'Data Kegiatan Mandiri berhasil diupdate');
  }
  // Hapus Data
  public function hapusDataIndependentActivities(string $idData)
  {
    //cek
    $cekData = IndependentActivities::findOrFail($idData);
    $cekData->delete();

    return redirect()->back()->with('success', 'Data prestasi mahasiswa berhasil dihapus!');
  }
}

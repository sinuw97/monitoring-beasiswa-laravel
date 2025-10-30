<?php

namespace App\Http\Controllers\mahasiswa\monev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\monev\OrganizationActivities;

use App\Services\GoogleDriveService;

class OrgActivitiesMonevController extends Controller
{
  // Submit Data
  public function submitKegOrg(Request $request, string $laporanId)
  {
    $dataMahasiswa = Auth::guard('mahasiswa')->user();

    $validated = $request->validate([
      'nama-ukm' => 'required|string|min:1|max:255',
      'nama-kegiatan' => 'required|string|min:1|max:255',
      'tingkat' => 'required|string|min:1|max:100',
      'posisi' => 'required|string|min:1|max:100',
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

    OrganizationActivities::create([
      'laporan_id' => $laporanId,
      'nim'        => $dataMahasiswa->nim,
      'ukm_name' => $validated['nama-ukm'],
      'activity_name' => $validated['nama-kegiatan'],
      'level' => $validated['tingkat'],
      'position' => $validated['posisi'],
      'place' => $validated['tempat'],
      'start_date' => $validated['tanggal-mulai'],
      'end_date' => $validated['tanggal-selesai'],
      'bukti_url' => $fileLink ?? 'Tidak Ada',
      'status' => 'Draft',
    ]);

    return redirect()->back()->with('success', 'Data Kegiatan Akademik berhasil ditambah!');
  }
  // Edit Data
  public function updateKegOrg(Request $request, string $idData)
  {
    $report = OrganizationActivities::findOrFail($idData);
    $dataMahasiswa = Auth::guard('mahasiswa')->user();

    $validated = $request->validate([
      'nama-ukm' => 'required|string|min:1|max:255',
      'nama-kegiatan' => 'required|string|min:1|max:255',
      'tingkat' => 'required|string|min:1|max:100',
      'posisi' => 'required|string|min:1|max:100',
      'tempat' => 'required|string|min:1|max:255',
      'tanggal-mulai' => 'required',
      'tanggal-selesai' => 'required',
      'bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $report->ukm_name = $validated['nama-ukm'];
    $report->activity_name = $validated['nama-kegiatan'];
    $report->level = $validated['tingkat'];
    $report->position = $validated['posisi'];
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

    return redirect()->back()->with('success', 'Data Kegiatan Organisasi berhasil diupdate');
  }
  // Hapus Data
  public function hapusDataOrganizationActivities(string $idData)
  {
    // cek
    $cekData = OrganizationActivities::findOrFail($idData);
    $cekData->delete();

    return redirect()->back()->with('success', 'Data kegiatan organisasi berhasil dihapus');
  }
}

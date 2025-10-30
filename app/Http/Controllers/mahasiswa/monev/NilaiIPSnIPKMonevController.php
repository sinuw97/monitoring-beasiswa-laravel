<?php

namespace App\Http\Controllers\mahasiswa\monev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\monev\AcademicReports;

use App\Services\GoogleDriveService;

class NilaiIPSnIPKMonevController extends Controller
{
  // Submit data
  public function submitNilaiIPKnIPS(Request $request, string $laporanId)
  {
    $dataMahasiswa = Auth::guard('mahasiswa')->user();

    $validated = $request->validate([
      'semester' => 'required|integer|min:1|max:8',
      'ips' => 'required|numeric|between:0,4',
      'ipk' => 'required|numeric|between:0,4',
      'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
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

    AcademicReports::create([
      'laporan_id' => $laporanId,
      'nim'        => $dataMahasiswa->nim,
      'semester'   => $validated['semester'],
      'ips'        => $validated['ips'],
      'ipk'        => $validated['ipk'],
      'bukti_url'  => $fileLink ?? 'Tidak Ada',
      'status'     => 'Draft',
    ]);

    return redirect()->back()->with('success', 'Data IPK dan IPS berhasil ditambah!');
  }

  // Edit Data
  public function updateNilaiIPKnIPS(Request $request, string $idData)
  {
    // Cek data apakaha ada?
    $report = AcademicReports::findOrFail($idData);
    $dataMahasiswa = Auth::guard('mahasiswa')->user();

    $validated = $request->validate([
      'semester' => 'required|integer|min:1|max:8',
      'ips' => 'required|numeric|between:0,4',
      'ipk' => 'required|numeric|between:0,4',
      'bukti'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $report->semester = $validated['semester'];
    $report->ips = $validated['ips'];
    $report->ipk = $validated['ipk'];

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

    return redirect()->back()->with('success', 'Data IPS dan IPK berhasil diupdate');
  }

  // Hapus Data
  public function hapusDataAcademicReport(string $idData)
  {
    // cek
    $cekData = AcademicReports::findOrFail($idData);
    $cekData->delete();

    return redirect()->back()->with('success', 'Data nilai IPK dan IPS berhasil dihapus!');
  }
}

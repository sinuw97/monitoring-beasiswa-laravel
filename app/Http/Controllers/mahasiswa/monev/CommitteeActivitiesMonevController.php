<?php

namespace App\Http\Controllers\mahasiswa\monev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\monev\CommitteeActivities;
use App\Models\monev\LaporanMonevMahasiswa;
use App\Models\semester\Periode;
use App\Services\GoogleDriveService;
use Carbon\Carbon;

class CommitteeActivitiesMonevController extends Controller
{
  // Submit data
  public function submitKegKomite(Request $request, string $laporanId)
  {
    $dataMahasiswa = Auth::guard('mahasiswa')->user();

    $validated = $request->validate([
      'nama-kegiatan' => 'required|string|min:1|max:255',
      'tipe-kegiatan' => 'required|string|min:1|max:255',
      'keikutsertaan' => 'required|string|min:1|max:100',
      'tingkat' => 'required|string|min:1|max:100',
      'tempat' => 'required|string|min:1|max:255',
      'tanggal-mulai' => 'required|date',
      'tanggal-selesai' => 'required|date|after_or_equal:tanggal-mulai',
      'bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
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

    CommitteeActivities::create([
      'laporan_id' => $laporanId,
      'nim'        => $dataMahasiswa->nim,
      'activity_name' => $validated['nama-kegiatan'],
      'activity_type' => $validated['tipe-kegiatan'],
      'participation' => $validated['keikutsertaan'],
      'level' => $validated['tingkat'],
      'place' => $validated['tempat'],
      'start_date' => $validated['tanggal-mulai'],
      'end_date' => $validated['tanggal-selesai'],
      'bukti_url' => $fileLink ?? "Tidak Ada", //Sementara
      'status' => 'Draft',
    ]);

    return redirect()->back()->with('success', 'Data Kegiatan Kepanitiaan atau Penugasan berhasil ditambah!');
  }
  // Edit Data
  public function updateKegKomite(Request $request, string $idData)
  {
    $report = CommitteeActivities::findOrFail($idData);
    $dataMahasiswa = Auth::guard('mahasiswa')->user();

    $validated = $request->validate([
      'nama-kegiatan' => 'required|string|min:1|max:255',
      'tipe-kegiatan' => 'required|string|min:1|max:255',
      'keikutsertaan' => 'required|string|min:1|max:100',
      'tingkat' => 'required|string|min:1|max:100',
      'tempat' => 'required|string|min:1|max:255',
      'tanggal-mulai' => 'required|date',
      'tanggal-selesai' => 'required|date|after_or_equal:tanggal-mulai',
      'bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
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
    $report->level = $validated['tingkat'];
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

    return redirect()->back()->with('success', 'Data Kegiatan Penugasan berhasil diupdate');
  }
  // Delete Data
  public function hapusDataCommitteeActivities(string $idData)
  {
    // cek
    $cekData = CommitteeActivities::findOrFail($idData);
    $cekData->delete();

    return redirect()->back()->with('success', 'Data kegiatan komite atau penugasan berhasil dihapus!');
  }
}

@extends('admin.layout') {{-- Anggap Anda menggunakan layout dasar Laravel/Tailwind --}}

@section('content')
<div class="container max-w-5xl mx-auto">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            {{-- Tombol untuk menutup alert (opsional) --}}
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none';">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.854l-2.651 2.995a1.2 1.2 0 1 1-1.697-1.697l2.651-2.995-2.651-2.995a1.2 1.2 0 1 1 1.697-1.697l2.651 2.995 2.651-2.995a1.2 1.2 0 1 1 1.697 1.697l-2.651 2.995 2.651 2.995a1.2 1.2 0 0 1 0 1.697z"/></svg>
            </span>
        </div>
    @endif
    <a href="/admin/laporan" class="flex rounded-lg py-2 px-6 my-8 bg-red-400 border-red-700 hover:bg-red-600 w-fit text-white">Kembali</a>
    <div class="h-auto bg-blue-200 px-3 py-3 rounded-lg">
        <p>Nama : {{ $dataMahasiswa->name }}</p>
        <p>NIM : {{ $dataMahasiswa->nim }}</p>
        <p>Periode : {{ $laporan->periodeSemester?->tahun_akademik }} {{ $laporan->periodeSemester?->semester }}
        </p>
        <p>Dibuat : {{ $laporan->created_at->translatedFormat('d F Y') }}</p>
        <p>Status : {{ $laporan->status }}</p>
    </div>
    <h2 class="text-2xl font-bold my-4">A. KEGIATAN AKADEMIK</h2>

    <h3 class="text-lg font-semibold text-gray-500 my-4">Nilai IPS dan IPK Semester Ini</h3>
    {{-- **Tabel Data Akademik** [Image of Academic report table] --}}
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Semester</th>
                    <th scope="col" class="px-6 py-3">IPS</th>
                    <th scope="col" class="px-6 py-3">IPK</th>
                    <th scope="col" class="px-6 py-3">Bukti</th>
                    <th scope="col" class="px-6 py-3">Komentar</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop data $academicReports --}}
                @foreach ($academicReports as $report)
                <tr class="bg-white border-b hover:bg-gray-50 ">
                    <td class="px-6 py-4">{{ $report['semester'] }}</td>
                    <td class="px-6 py-4">{{ $report['ips'] }}</td>
                    <td class="px-6 py-4">{{ $report['ipk'] }}</td>
                    <td class="px-6 py-4">
                        @if ($report['bukti_url'] == 'Tidak Ada')
                            <span>Tidak Ada</span>
                        @else
                            <a href="{{ $report['bukti_url'] }}" target="_blank" class="font-medium text-blue-600  hover:underline">Lihat Bukti</a>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $report['comment'] ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="p-1 rounded text-xs font-semibold
                            @if ($report['status'] == 'Valid') border border-green-800 bg-green-100 text-green-800
                            @elseif ($report['status'] == 'Rejected') border border-red-800 bg-red-100 text-red-800
                            @elseif ($report['status'] == 'Pending') border border-grey-800 bg-grey-100 text-grey-800
                            @else border border-yellow-800 bg-yellow-100 text-yellow-800
                            @endif">
                            {{ $report['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        {{-- **Tombol Aksi: Menggunakan Anchor Tag untuk memicu Modal** --}}
                        <a href="#editModal-{{ $report['id'] }}" class="font-medium bg-indigo-100 rounded-lg py-2 px-4 hover:bg-indigo-400 hover:text-white">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($academicReports as $report)
        @include('components.modal-laporan-admin', [
            'report' => $report,
            'type' => 'academic-reports',
            'modalId' => 'editModal-' . $report['id']
        ])
    @endforeach

    <h3 class="text-lg font-semibold text-gray-500 my-4">Kegiatan Akademik</h3>
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Kegiatan</th>
                    <th scope="col" class="px-6 py-3">Tipe</th>
                    <th scope="col" class="px-6 py-3">Keikutsertaan</th>
                    <th scope="col" class="px-6 py-3">Tempat</th>
                    <th scope="col" class="px-6 py-3">Tanggal Mulai</th>
                    <th scope="col" class="px-6 py-3">Tanggal Selesai</th>
                    <th scope="col" class="px-6 py-3">Bukti</th>
                    <th scope="col" class="px-6 py-3">Komentar</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop data $academicReports --}}
                @foreach ($academicActivities as $report)
                <tr class="bg-white border-b hover:bg-gray-50 ">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $report['activity_name'] }}</td>
                    <td class="px-6 py-4">{{ $report['activity_type'] }}</td>
                    <td class="px-6 py-4">{{ $report['participation'] }}</td>
                    <td class="px-6 py-4">{{ $report['place'] }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($report['start_date'])->format('d M Y') }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($report['end_date'])->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                         @if ($report['bukti_url'] == 'Tidak Ada')
                            <span>Tidak Ada</span>
                        @else
                            <a href="{{ $report['bukti_url'] }}" target="_blank" class="font-medium text-blue-600  hover:underline">Lihat Bukti</a>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $report['comment'] ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="p-1 rounded text-xs font-semibold
                            @if ($report['status'] == 'Valid') border border-green-800 bg-green-100 text-green-800
                            @elseif ($report['status'] == 'Rejected') border border-red-800 bg-red-100 text-red-800
                            @elseif ($report['status'] == 'Pending') border border-grey-800 bg-grey-100 text-grey-800
                            @else border border-yellow-800 bg-yellow-100 text-yellow-800
                            @endif">
                            {{ $report['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        {{-- **Tombol Aksi: Menggunakan Anchor Tag untuk memicu Modal** --}}
                        <a href="#editModal-{{ $report['id'] }}" class="font-medium bg-indigo-100 rounded-lg py-2 px-4 hover:bg-indigo-400 hover:text-white">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($academicActivities as $report)
        @include('components.modal-laporan-admin', [
            'report' => $report,
            'type' => 'academic-activities',
            'modalId' => 'editModal-' . $report['id']
        ])
    @endforeach

    <h2 class="text-2xl font-bold my-4">B. KEGIATAN NON AKADEMIK</h2>

    <h3 class="text-lg font-semibold text-gray-500 my-4">Kegiatan Organisasi Mahasiswa</h3>
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Nama UKM</th>
                    <th scope="col" class="px-6 py-3">Kegiatan</th>
                    <th scope="col" class="px-6 py-3">Tingkat</th>
                    <th scope="col" class="px-6 py-3">Keikutsertaan</th>
                    <th scope="col" class="px-6 py-3">Tempat</th>
                    <th scope="col" class="px-6 py-3">Tanggal Mulai</th>
                    <th scope="col" class="px-6 py-3">Tanggal Selesai</th>
                    <th scope="col" class="px-6 py-3">Bukti</th>
                    <th scope="col" class="px-6 py-3">Komentar</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop data $academicReports --}}
                @foreach ($organizationActivities as $report)
                <tr class="bg-white border-b hover:bg-gray-50 ">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $report['ukm_name'] }}</td>
                    <td class="px-6 py-4">{{ $report['activity_name'] }}</td>
                    <td class="px-6 py-4">{{ $report['level'] }}</td>
                    <td class="px-6 py-4">{{ $report['position'] }}</td>
                    <td class="px-6 py-4">{{ $report['place'] }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($report['start_date'])->format('d M Y') }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($report['end_date'])->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                         @if ($report['bukti_url'] == 'Tidak Ada')
                            <span>Tidak Ada</span>
                        @else
                            <a href="{{ $report['bukti_url'] }}" target="_blank" class="font-medium text-blue-600  hover:underline">Lihat Bukti</a>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $report['comment'] ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="p-1 rounded text-xs font-semibold
                        @if ($report['status'] == 'Valid') border border-green-800 bg-green-100 text-green-800
                            @elseif ($report['status'] == 'Rejected') border border-red-800 bg-red-100 text-red-800
                            @elseif ($report['status'] == 'Pending') border border-grey-800 bg-grey-100 text-grey-800
                            @else border border-yellow-800 bg-yellow-100 text-yellow-800
                            @endif">
                            {{ $report['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        {{-- **Tombol Aksi: Menggunakan Anchor Tag untuk memicu Modal** --}}
                        <a href="#editModal-{{ $report['id'] }}" class="font-medium bg-indigo-100 rounded-lg py-2 px-4 hover:bg-indigo-400 hover:text-white">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($organizationActivities as $report)
    @include('components.modal-laporan-admin', [
        'report' => $report,
            'type' => 'organization-activities',
            'modalId' => 'editModal-' . $report['id']
            ])
    @endforeach

    <h3 class="text-lg font-semibold text-gray-500 my-4">Kegiatan Kepanitiaan Atau Penugasan</h3>
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Kegiatan</th>
                    <th scope="col" class="px-6 py-3">Tipe</th>
                    <th scope="col" class="px-6 py-3">Tingkat</th>
                    <th scope="col" class="px-6 py-3">Keikutsertaan</th>
                    <th scope="col" class="px-6 py-3">Tempat</th>
                    <th scope="col" class="px-6 py-3">Tanggal Mulai</th>
                    <th scope="col" class="px-6 py-3">Tanggal Selesai</th>
                    <th scope="col" class="px-6 py-3">Bukti</th>
                    <th scope="col" class="px-6 py-3">Komentar</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop data $academicReports --}}
                @foreach ($committeeActivities as $report)
                <tr class="bg-white border-b hover:bg-gray-50 ">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $report['activity_name'] }}</td>
                    <td class="px-6 py-4">{{ $report['activity_type'] }}</td>
                    <td class="px-6 py-4">{{ $report['level'] }}</td>
                    <td class="px-6 py-4">{{ $report['participation'] }}</td>
                    <td class="px-6 py-4">{{ $report['place'] }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($report['start_date'])->format('d M Y') }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($report['end_date'])->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                         @if ($report['bukti_url'] == 'Tidak Ada')
                            <span>Tidak Ada</span>
                        @else
                            <a href="{{ $report['bukti_url'] }}" target="_blank" class="font-medium text-blue-600  hover:underline">Lihat Bukti</a>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $report['comment'] ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="p-1 rounded text-xs font-semibold
                            @if ($report['status'] == 'Valid') border border-green-800 bg-green-100 text-green-800
                            @elseif ($report['status'] == 'Rejected') border border-red-800 bg-red-100 text-red-800
                            @elseif ($report['status'] == 'Pending') border border-grey-800 bg-grey-100 text-grey-800
                            @else border border-yellow-800 bg-yellow-100 text-yellow-800
                            @endif">
                            {{ $report['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        {{-- **Tombol Aksi: Menggunakan Anchor Tag untuk memicu Modal** --}}
                        <a href="#editModal-{{ $report['id'] }}" class="font-medium bg-indigo-100 rounded-lg py-2 px-4 hover:bg-indigo-400 hover:text-white">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($committeeActivities as $report)
    @include('components.modal-laporan-admin', [
            'report' => $report,
            'type' => 'committee-activities',
            'modalId' => 'editModal-' . $report['id']
            ])
    @endforeach

    <h3 class="text-lg font-semibold text-gray-500 my-4">Prestasi Mahasiswa</h3>
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Prestasi</th>
                    <th scope="col" class="px-6 py-3">Tipe</th>
                    <th scope="col" class="px-6 py-3">Tingkat</th>
                    <th scope="col" class="px-6 py-3">Raihan</th>
                    <th scope="col" class="px-6 py-3">Tempat</th>
                    <th scope="col" class="px-6 py-3">Tanggal Mulai</th>
                    <th scope="col" class="px-6 py-3">Tanggal Selesai</th>
                    <th scope="col" class="px-6 py-3">Bukti</th>
                    <th scope="col" class="px-6 py-3">Komentar</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop data $academicReports --}}
                @foreach ($studentAchievements as $report)
                <tr class="bg-white border-b hover:bg-gray-50 ">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $report['achievements_name'] }}</td>
                    <td class="px-6 py-4">{{ $report['achievements_type'] }}</td>
                    <td class="px-6 py-4">{{ $report['level'] }}</td>
                    <td class="px-6 py-4">{{ $report['award'] }}</td>
                    <td class="px-6 py-4">{{ $report['place'] }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($report['start_date'])->format('d M Y') }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($report['end_date'])->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                         @if ($report['bukti_url'] == 'Tidak Ada')
                            <span>Tidak Ada</span>
                        @else
                            <a href="{{ $report['bukti_url'] }}" target="_blank" class="font-medium text-blue-600  hover:underline">Lihat Bukti</a>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $report['comment'] ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="p-1 rounded text-xs font-semibold
                            @if ($report['status'] == 'Valid') border border-green-800 bg-green-100 text-green-800
                            @elseif ($report['status'] == 'Rejected') border border-red-800 bg-red-100 text-red-800
                            @elseif ($report['status'] == 'Pending') border border-grey-800 bg-grey-100 text-grey-800
                            @else border border-yellow-800 bg-yellow-100 text-yellow-800
                            @endif">
                            {{ $report['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        {{-- **Tombol Aksi: Menggunakan Anchor Tag untuk memicu Modal** --}}
                        <a href="#editModal-{{ $report['id'] }}" class="font-medium bg-indigo-100 rounded-lg py-2 px-4 hover:bg-indigo-400 hover:text-white">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($studentAchievements as $report)
        @include('components.modal-laporan-admin', [
            'report' => $report,
            'type' => 'student-achievements',
            'modalId' => 'editModal-' . $report['id']
        ])
    @endforeach

    <h3 class="text-lg font-semibold text-gray-500 my-4">Kegiatan Mandiri Mahasiswa Selama Satu Semester</h3>
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Kegiatan</th>
                    <th scope="col" class="px-6 py-3">Tipe</th>
                    <th scope="col" class="px-6 py-3">Keikutsertaan</th>
                    <th scope="col" class="px-6 py-3">Tempat</th>
                    <th scope="col" class="px-6 py-3">Tanggal Mulai</th>
                    <th scope="col" class="px-6 py-3">Tanggal Selesai</th>
                    <th scope="col" class="px-6 py-3">Bukti</th>
                    <th scope="col" class="px-6 py-3">Komentar</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop data $academicReports --}}
                @foreach ($independentActivities as $report)
                <tr class="bg-white border-b hover:bg-gray-50 ">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $report['activity_name'] }}</td>
                    <td class="px-6 py-4">{{ $report['activity_type'] }}</td>
                    <td class="px-6 py-4">{{ $report['participation'] }}</td>
                    <td class="px-6 py-4">{{ $report['place'] }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($report['start_date'])->format('d M Y') }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($report['end_date'])->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                         @if ($report['bukti_url'] == 'Tidak Ada')
                            <span>Tidak Ada</span>
                        @else
                            <a href="{{ $report['bukti_url'] }}" target="_blank" class="font-medium text-blue-600  hover:underline">Lihat Bukti</a>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $report['comment'] ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="p-1 rounded text-xs font-semibold
                        @if ($report['status'] == 'Valid') border border-green-800 bg-green-100 text-green-800
                            @elseif ($report['status'] == 'Rejected') border border-red-800 bg-red-100 text-red-800
                            @elseif ($report['status'] == 'Pending') border border-grey-800 bg-grey-100 text-grey-800
                            @else border border-yellow-800 bg-yellow-100 text-yellow-800
                            @endif">
                            {{ $report['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        {{-- **Tombol Aksi: Menggunakan Anchor Tag untuk memicu Modal** --}}
                        <a href="#editModal-{{ $report['id'] }}" class="font-medium bg-indigo-100 rounded-lg py-2 px-4 hover:bg-indigo-400 hover:text-white">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($independentActivities as $report)
        @include('components.modal-laporan-admin', [
            'report' => $report,
            'type' => 'independent-activities',
            'modalId' => 'editModal-' . $report['id']
            ])
    @endforeach

    <h2 class="text-2xl font-bold my-4">C. EVALUASI</h2>
        @foreach ($evaluations as $report)
        <div class="grid grid-cols-2 gap-2">
            <div class="w-full">
                <h3 class="text-lg font-semibold text-gray-500 my-4">Faktor Pendukung</h3>
                <textarea
                    id="modern-textarea-focus"
                    name="important_notes"
                    rows="5"
                    class="block w-full
                        px-4 py-3
                        text-base
                        text-gray-800
                        bg-gray-50 {{-- Background sedikit abu-abu terlihat lebih modern --}}
                        border
                        border-gray-200
                        rounded-xl {{-- Rounded yang lebih besar (xl) --}}
                        shadow-md
                        focus:outline-none
                        focus:ring-2
                        focus:ring-indigo-500
                        focus:border-indigo-500
                        focus:shadow-lg {{-- Efek shadow saat fokus --}}
                        transition
                        duration-300
                        ease-in-out
                        resize-none" {{-- resize-none untuk menjaga tata letak --}}
                >
                    {{$report['support_factors'] ?? '-'}}
                </textarea>
            </div>

            <div class="w-full">
                <h3 class="text-lg font-semibold text-gray-500 my-4">Faktor Penghambat</h3>
                <textarea
                    id="modern-textarea-focus"
                    name="important_notes"
                    rows="5"
                    class="block w-full
                        px-4 py-3
                        text-base
                        text-gray-800
                        bg-gray-50 {{-- Background sedikit abu-abu terlihat lebih modern --}}
                        border
                        border-gray-200
                        rounded-xl {{-- Rounded yang lebih besar (xl) --}}
                        shadow-md
                        focus:outline-none
                        focus:ring-2
                        focus:ring-indigo-500
                        focus:border-indigo-500
                        focus:shadow-lg {{-- Efek shadow saat fokus --}}
                        transition
                        duration-300
                        ease-in-out
                        resize-none" {{-- resize-none untuk menjaga tata letak --}}
                >
                    {{$report['barrier_factors'] ?? '-'}}
                </textarea>
            </div>
        </div>
        <div class="">
            <span class="p-1 rounded text-xs font-semibold
                @if ($report['status'] == 'Valid') border border-green-800 bg-green-100 text-green-800
                @elseif ($report['status'] == 'Rejected') border border-red-800 bg-red-100 text-red-800
                @elseif ($report['status'] == 'Pending') border border-grey-800 bg-grey-100 text-grey-800
                @else border border-yellow-800 bg-yellow-100 text-yellow-800
                @endif">
                {{ $report['status'] }}
            </span>
            <a href="#editModal-{{ $report['id'] }}" class="font-medium bg-indigo-100 rounded-lg py-2 px-4 hover:bg-indigo-400 hover:text-white">
                Edit
            </a>
        </div>

        @endforeach

        @foreach ($evaluations as $report)
            @include('components.modal-laporan-admin', [
                'report' => $report,
                'type' => 'evaluations',
                'modalId' => 'editModal-' . $report['id']
            ])
        @endforeach

    <h2 class="text-2xl font-bold my-4">D. TARGET SEMESTER DEPAN</h2>

    <h3 class="text-lg font-semibold text-gray-500 my-4">Rencana Nilai IPS dan IPK Semester Depan</h3>
    {{-- **Tabel Data Akademik** [Image of Academic report table] --}}
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Semester</th>
                    <th scope="col" class="px-6 py-3">IPS</th>
                    <th scope="col" class="px-6 py-3">IPK</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop data $academicReports --}}
                @foreach ($targetNextSemester as $report)
                <tr class="bg-white border-b hover:bg-gray-50 ">
                    <td class="px-6 py-4">{{ $report['semester'] }}</td>
                    <td class="px-6 py-4">{{ $report['target_ips'] }}</td>
                    <td class="px-6 py-4">{{ $report['target_ipk'] }}</td>
                    <td class="px-6 py-4">
                        <span class="p-1 rounded text-xs font-semibold
                            @if ($report['status'] == 'Valid') border border-green-800 bg-green-100 text-green-800
                            @elseif ($report['status'] == 'Rejected') border border-red-800 bg-red-100 text-red-800
                            @elseif ($report['status'] == 'Pending') border border-grey-800 bg-grey-100 text-grey-800
                            @else border border-yellow-800 bg-yellow-100 text-yellow-800
                            @endif">
                            {{ $report['status'] }}
                        </span>
                    </td>
                    <td class="flex px-6 py-4">
                        {{-- **Tombol Aksi: Menggunakan Anchor Tag untuk memicu Modal** --}}
                        <a href="#editModal-{{ $report['id'] }}" class="mx-auto font-medium bg-indigo-100 rounded-lg py-2 px-4 hover:bg-indigo-400 hover:text-white">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($targetNextSemester as $report)
        @include('components.modal-laporan-admin', [
            'report' => $report,
            'type' => 'target-reports',
            'modalId' => 'editModal-' . $report['id']
        ])
    @endforeach

    <h3 class="text-lg font-semibold text-gray-500 my-4">Rencana Kegiatan Akademik</h3>
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Kegiatan</th>
                    <th scope="col" class="px-6 py-3">Rencana/Strategi</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop data $academicReports --}}
                @foreach ($targetAcademicActivities as $report)
                <tr class="bg-white border-b hover:bg-gray-50 ">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $report['activity_name'] }}</td>
                    <td class="px-6 py-4">{{ $report['strategy'] }}</td>
                    <td class="px-6 py-4">
                        <span class="p-1 rounded text-xs font-semibold
                            @if ($report['status'] == 'Valid') border border-green-800 bg-green-100 text-green-800
                            @elseif ($report['status'] == 'Rejected') border border-red-800 bg-red-100 text-red-800
                            @elseif ($report['status'] == 'Pending') border border-grey-800 bg-grey-100 text-grey-800
                            @else border border-yellow-800 bg-yellow-100 text-yellow-800
                            @endif">
                            {{ $report['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        {{-- **Tombol Aksi: Menggunakan Anchor Tag untuk memicu Modal** --}}
                        <a href="#editModal-{{ $report['id'] }}" class="font-medium bg-indigo-100 rounded-lg py-2 px-4 hover:bg-indigo-400 hover:text-white">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($targetAcademicActivities as $report)
        @include('components.modal-laporan-admin', [
            'report' => $report,
            'type' => 'target-activities',
            'modalId' => 'editModal-' . $report['id']
        ])
    @endforeach

    <h3 class="text-lg font-semibold text-gray-500 my-4">Rencana Prestasi Mahasiswa</h3>
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Prestasi</th>
                    <th scope="col" class="px-6 py-3">Tingkat</th>
                    <th scope="col" class="px-6 py-3">Raihan</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop data $academicReports --}}
                @foreach ($targetAchievements as $report)
                <tr class="bg-white border-b hover:bg-gray-50 ">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $report['achievements_name'] }}</td>
                    <td class="px-6 py-4">{{ $report['level'] }}</td>
                    <td class="px-6 py-4">{{ $report['award'] }}</td>
                    <td class="px-6 py-4">
                        <span class="p-1 rounded text-xs font-semibold
                            @if ($report['status'] == 'Valid') border border-green-800 bg-green-100 text-green-800
                            @elseif ($report['status'] == 'Rejected') border border-red-800 bg-red-100 text-red-800
                            @elseif ($report['status'] == 'Pending') border border-grey-800 bg-grey-100 text-grey-800
                            @else border border-yellow-800 bg-yellow-100 text-yellow-800
                            @endif">
                            {{ $report['status'] }}
                        </span>
                    </td>
                    <td class="flex px-6 py-4">
                        {{-- **Tombol Aksi: Menggunakan Anchor Tag untuk memicu Modal** --}}
                        <a href="#editModal-{{ $report['id'] }}" class="mx-auto font-medium bg-indigo-100 rounded-lg py-2 px-4 hover:bg-indigo-400 hover:text-white">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($targetAchievements as $report)
        @include('components.modal-laporan-admin', [
            'report' => $report,
            'type' => 'target-achievements',
            'modalId' => 'editModal-' . $report['id']
        ])
    @endforeach

    <h3 class="text-lg font-semibold text-gray-500 my-4">Rencana Kegiatan Mandiri</h3>
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Kegiatan</th>
                    <th scope="col" class="px-6 py-3">Keikutsertaan</th>
                    <th scope="col" class="px-6 py-3">Rencana/Srategi</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop data $academicReports --}}
                @foreach ($targetIdependentActivities as $report)
                <tr class="bg-white border-b hover:bg-gray-50 ">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $report['activity_name'] }}</td>
                    <td class="px-6 py-4">{{ $report['participation'] }}</td>
                    <td class="px-6 py-4">{{ $report['strategy'] }}</td>
                    <td class="px-6 py-4">
                        <span class="p-1 rounded text-xs font-semibold
                        @if ($report['status'] == 'Valid') border border-green-800 bg-green-100 text-green-800
                            @elseif ($report['status'] == 'Rejected') border border-red-800 bg-red-100 text-red-800
                            @elseif ($report['status'] == 'Pending') border border-grey-800 bg-grey-100 text-grey-800
                            @else border border-yellow-800 bg-yellow-100 text-yellow-800
                            @endif">
                            {{ $report['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        {{-- **Tombol Aksi: Menggunakan Anchor Tag untuk memicu Modal** --}}
                        <a href="#editModal-{{ $report['id'] }}" class="font-medium bg-indigo-100 rounded-lg py-2 px-4 hover:bg-indigo-400 hover:text-white">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($targetIdependentActivities as $report)
        @include('components.modal-laporan-admin', [
            'report' => $report,
            'type' => 'target-independent',
            'modalId' => 'editModal-' . $report['id']
            ])
    @endforeach

    <form action="/admin/laporan/{{ $laporan->laporan_id }}" method="POST" class="my-8 flex flex-col gap-4">
        @csrf
        @method('put')
        <select name="status" class="{{$laporan->status == 'Draft' || $laporan->status == 'Pending'? 'p-2 border border-gray-500 bg-gray-300 rounded-lg text-white' : ($laporan->status == 'Lolos' || $laporan->status == 'Lolos dengan penugasan' ? 'p-2 border border-green-500 bg-green-300 rounded-lg text-white' : 'p-2 border border-red-500 bg-red-300 rounded-lg text-white')}}">
            <option value="Draft" {{ $laporan->status == 'Draft' ? 'selected' : '' }} class="text-center bg-white text-black">Draft</option>
            <option value="Pending" {{ $laporan->status == 'Pending' ? 'selected' : '' }} class="text-center bg-white text-black">Pending</option>
            <option value="Ditolak SP-1" {{ $laporan->status == 'Ditolak SP-1' ? 'selected' : '' }} class="text-center bg-white text-black">Ditolak SP-1</option>
            <option value="Ditolak SP-2" {{ $laporan->status == 'Ditolak SP-2' ? 'selected' : '' }} class="text-center bg-white text-black">Ditolak SP-2</option>
            <option value="Ditolak SP-3" {{ $laporan->status == 'Ditolak SP-3' ? 'selected' : '' }} class="text-center bg-white text-black">Ditolak SP-3</option>
            <option value="Lolos dengan penugasan" {{ $laporan->status == 'Lolos dengan penugasan' ? 'selected' : '' }} class="text-center bg-white text-black">Lolos dengan penugasan</option>
            <option value="Lolos" {{ $laporan->status == 'Lolos' ? 'selected' : '' }} class="text-center bg-white text-black">Lolos</option>
        </select>
        <button class="p-2 bg-[#09697E] border-[#064c5c] text-white rounded-lg">Submit</button>
    </form>
</div>
@endsection

<style>
    /* Menyembunyikan modal secara default */
    .modal-target {
        visibility: hidden;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    /* Menampilkan modal ketika #id dipanggil di URL */
    :target {
        visibility: visible;
        opacity: 1;
        pointer-events: auto;
    }
</style>

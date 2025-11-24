@extends('admin.layout')

@section('content')
    <div class="container max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md flex justify-between items-center"
                role="alert">
                <div class="flex items-center">
                    <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                    </svg>
                    <div>
                        <p class="font-bold">Berhasil!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        @endif

        {{-- Tombol Kembali --}}
        <a href="/admin/laporan"
            class="inline-flex items-center justify-center rounded-lg py-2 px-4 mb-6 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:text-[#09697E] transition duration-300 shadow-sm font-medium text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Daftar Laporan
        </a>

        {{-- Header Laporan (Data Mahasiswa) 📋 --}}
        <div class="bg-white border-t-4 border-[#09697E] p-6 rounded-xl shadow-lg mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <h1 class="text-xl sm:text-2xl font-bold text-[#09697E]">Detail Laporan Monitoring</h1>
                <div class="mt-2 md:mt-0">
                    <span
                        class="px-3 py-1 rounded-full text-sm font-bold shadow-sm
                    @if ($laporan->status == 'Lolos' || $laporan->status == 'Lolos dengan penugasan') bg-green-100 text-green-800 border border-green-200
                    @elseif (Str::contains($laporan->status, 'Ditolak')) bg-red-100 text-red-800 border border-red-200
                    @elseif ($laporan->status == 'Pending') bg-yellow-100 text-yellow-800 border border-yellow-200
                    @else bg-gray-100 text-gray-800 border border-gray-200 @endif">
                        {{ $laporan->status }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
                <div class="space-y-3">
                    <div class="flex border-b border-gray-100 pb-2">
                        <span class="font-semibold w-1/3 text-gray-500">Nama</span>
                        <span class="w-2/3 font-medium text-gray-900">{{ $dataMahasiswa->name }}</span>
                    </div>
                    <div class="flex border-b border-gray-100 pb-2">
                        <span class="font-semibold w-1/3 text-gray-500">NIM</span>
                        <span class="w-2/3 font-medium text-gray-900">{{ $dataMahasiswa->nim }}</span>
                    </div>
                    <div class="flex border-b border-gray-100 pb-2">
                        <span class="font-semibold w-1/3 text-gray-500">Periode</span>
                        <span class="w-2/3 font-medium text-gray-900">{{ $laporan->periodeSemester?->tahun_akademik }}
                            {{ $laporan->periodeSemester?->semester }}</span>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex border-b border-gray-100 pb-2">
                        <span class="font-semibold w-1/3 text-gray-500">Dibuat</span>
                        <span
                            class="w-2/3 font-medium text-gray-900">{{ $laporan->created_at->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="flex border-b border-gray-100 pb-2">
                        <span class="font-semibold w-1/3 text-gray-500">Total Points</span>
                        <span class="w-2/3 font-bold text-[#E8BE00] text-lg">{{ $totalPoints }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bagian A: Kegiatan Akademik --}}
        <section class="mb-10">
            <div class="flex items-center mb-6">
                <div class="bg-[#09697E] w-1 h-8 rounded-r mr-3"></div>
                <h2 class="text-xl font-bold text-gray-800">A. KEGIATAN AKADEMIK</h2>
            </div>

            {{-- Sub-bagian: Nilai IPS dan IPK Semester Ini --}}
            @php
                $academicReports = $academicReports ?? [];
            @endphp
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 mb-6">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-semibold text-[#09697E]">Nilai IPS dan IPK Semester Ini</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-semibold">Semester</th>
                                <th scope="col" class="px-6 py-3 font-semibold hidden md:table-cell">IPS</th>
                                <th scope="col" class="px-6 py-3 font-semibold hidden md:table-cell">IPK</th>
                                <th scope="col" class="px-6 py-3 font-semibold hidden md:table-cell">Bukti</th>
                                <th scope="col" class="px-6 py-3 font-semibold hidden md:table-cell">Komentar</th>
                                <th scope="col" class="px-6 py-3 font-semibold hidden md:table-cell">Status</th>
                                <th scope="col" class="px-6 py-3 font-semibold text-center hidden md:table-cell">Aksi
                                </th>
                                <th scope="col" class="px-6 py-3 font-semibold text-center md:hidden">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($academicReports as $report)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $report['semester'] }}</td>
                                    <td class="px-6 py-4 hidden md:table-cell">{{ $report['ips'] }}</td>
                                    <td class="px-6 py-4 hidden md:table-cell">{{ $report['ipk'] }}</td>
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        @if ($report['bukti_url'] != 'Tidak Ada' && $report['bukti_url'])
                                            <a href="{{ $report['bukti_url'] }}" target="_blank"
                                                class="text-[#09697E] hover:text-[#075263] hover:underline flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                    </path>
                                                </svg>
                                                Lihat
                                            </a>
                                        @else
                                            <span class="text-gray-400">Tidak Ada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 hidden md:table-cell text-gray-600">
                                        {{ $report['comment'] ?? '-' }}</td>
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        @include('components.status-badge', [
                                            'status' => $report['status'],
                                        ])
                                    </td>
                                    <td class="px-6 py-4 text-center hidden md:table-cell">
                                        <a href="#editModal-academic-reports-{{ $report['id'] }}"
                                            class="text-[#09697E] hover:text-[#075263] bg-cyan-50 hover:bg-cyan-100 p-2 rounded-lg transition inline-flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center md:hidden">
                                        <a href="#detailModal-academic-reports-{{ $report['id'] }}"
                                            class="text-[#09697E] bg-cyan-50 hover:bg-cyan-100 px-3 py-1 rounded-md text-xs font-medium transition">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if (count($academicReports) > 0)
                @foreach ($academicReports as $report)
                    @include('components.modal-laporan-admin', [
                        'report' => $report,
                        'type' => 'academic-reports',
                        'modalId' => 'editModal-academic-reports-' . $report['id'],
                    ])
                    {{-- Modal Detail Mobile --}}
                    @include('components.detail-mobile-modal', [
                        'report' => $report,
                        'modalId' => 'detailModal-academic-reports-' . $report['id'],
                        'type' => 'academic-reports',
                        'fields' => [
                            'IPS' => $report['ips'],
                            'IPK' => $report['ipk'],
                            'Semester' => $report['semester'],
                            'Komentar' => $report['comment'] ?? '-',
                            'Status' => $report['status'],
                            'Bukti' => $report['bukti_url'],
                        ],
                    ])
                @endforeach
            @endif

            {{-- Sub-bagian: Kegiatan Akademik Lain --}}
            @php
                $academicActivities = $academicActivities ?? [];
            @endphp
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 mb-6">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-semibold text-[#09697E]">Kegiatan Akademik Lain</h3>
                </div>
                @if (count($academicActivities) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-semibold">#</th>
                                    <th scope="col" class="px-6 py-3 font-semibold">Kegiatan</th>
                                    <th scope="col" class="px-6 py-3 font-semibold hidden sm:table-cell">Tipe</th>
                                    <th scope="col" class="px-6 py-3 font-semibold hidden lg:table-cell">Keikutsertaan
                                    </th>
                                    <th scope="col" class="px-6 py-3 font-semibold hidden md:table-cell">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 font-semibold hidden sm:table-cell">Bukti</th>
                                    <th scope="col" class="px-6 py-3 font-semibold hidden md:table-cell">Points</th>
                                    <th scope="col" class="px-6 py-3 font-semibold hidden sm:table-cell">Status</th>
                                    <th scope="col" class="px-6 py-3 font-semibold text-center hidden sm:table-cell">
                                        Aksi</th>
                                    <th scope="col" class="px-6 py-3 font-semibold text-center sm:hidden">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($academicActivities as $report)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $loop->iteration }}</td>
                                        <td
                                            class="px-6 py-4 text-xs sm:text-sm max-w-[150px] truncate font-medium text-gray-900">
                                            {{ $report['activity_name'] }}</td>
                                        <td class="px-6 py-4 hidden sm:table-cell">{{ $report['activity_type'] }}</td>
                                        <td class="px-6 py-4 hidden lg:table-cell">{{ $report['participation'] }}</td>
                                        <td class="px-6 py-4 hidden md:table-cell text-gray-600">
                                            {{ \Carbon\Carbon::parse($report['start_date'])->format('d M Y') }}</td>
                                        <td class="px-6 py-4 hidden sm:table-cell">
                                            @if ($report['bukti_url'] != 'Tidak Ada' && $report['bukti_url'])
                                                <a href="{{ $report['bukti_url'] }}" target="_blank"
                                                    class="text-[#09697E] hover:text-[#075263] hover:underline flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                        </path>
                                                    </svg>
                                                    Lihat
                                                </a>
                                            @else
                                                <span class="text-gray-400">Tidak Ada</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 hidden md:table-cell font-semibold text-[#E8BE00]">
                                            {{ $report['points' ?? '-'] }}
                                        </td>
                                        <td class="px-6 py-4 hidden sm:table-cell">
                                            @include('components.status-badge', [
                                                'status' => $report['status'],
                                            ])
                                        </td>
                                        <td class="px-6 py-4 text-center hidden sm:table-cell">
                                            <a href="#editModal-academic-activities-{{ $report['id'] }}"
                                                class="text-[#09697E] hover:text-[#075263] bg-cyan-50 hover:bg-cyan-100 p-2 rounded-lg transition inline-flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-center sm:hidden">
                                            <a href="#detailModal-academic-activities-{{ $report['id'] }}"
                                                class="text-[#09697E] bg-cyan-50 hover:bg-cyan-100 px-3 py-1 rounded-md text-xs font-medium transition">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center">
                        <p class="text-gray-500 italic">Tidak ada kegiatan akademik yang dilaporkan.</p>
                    </div>
                @endif
            </div>
            @if (count($academicActivities) > 0)
                @foreach ($academicActivities as $report)
                    @include('components.modal-laporan-admin', [
                        'report' => $report,
                        'type' => 'academic-activities',
                        'modalId' => 'editModal-academic-activities-' . $report['id'],
                    ])
                    {{-- Modal Detail Mobile --}}
                    @include('components.detail-mobile-modal', [
                        'report' => $report,
                        'modalId' => 'detailModal-academic-activities-' . $report['id'],
                        'type' => 'academic-activities',
                        'fields' => [
                            'Kegiatan' => $report['activity_name'],
                            'Tipe' => $report['activity_type'],
                            'Keikutsertaan' => $report['participation'],
                            'Tanggal' => \Carbon\Carbon::parse($report['start_date'])->format('d M Y'),
                            'Points' => $report['points'] ?? '-',
                            'Status' => $report['status'],
                            'Bukti' => $report['bukti_url'],
                        ],
                    ])
                @endforeach
            @endif
        </section>

        <hr class="my-8 border-gray-300">

        {{-- Bagian B: Kegiatan Non Akademik --}}
        <section class="mb-10">
            <div class="flex items-center mb-6">
                <div class="bg-[#09697E] w-1 h-8 rounded-r mr-3"></div>
                <h2 class="text-xl font-bold text-gray-800">B. KEGIATAN NON AKADEMIK</h2>
            </div>

            {{-- Sub-bagian: Kegiatan Organisasi Mahasiswa --}}
            @php
                $organizationActivities = $organizationActivities ?? [];
            @endphp
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 mb-6">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-semibold text-[#09697E]">Kegiatan Organisasi Mahasiswa</h3>
                </div>
                @if (count($organizationActivities) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-semibold">#</th>
                                    <th scope="col" class="px-6 py-3 font-semibold">UKM/Kegiatan</th>
                                    <th scope="col" class="px-6 py-3 font-semibold hidden sm:table-cell">Tingkat/Posisi
                                    </th>
                                    <th scope="col" class="px-6 py-3 font-semibold hidden md:table-cell">Tanggal Mulai
                                    </th>
                                    <th scope="col" class="px-6 py-3 font-semibold hidden sm:table-cell">Bukti</th>
                                    <th scope="col" class="px-6 py-3 font-semibold hidden md:table-cell">Points</th>
                                    <th scope="col" class="px-6 py-3 font-semibold hidden sm:table-cell">Status</th>
                                    <th scope="col" class="px-6 py-3 font-semibold text-center hidden sm:table-cell">
                                        Aksi</th>
                                    <th scope="col" class="px-6 py-3 font-semibold text-center sm:hidden">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($organizationActivities as $report)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $loop->iteration }}</td>
                                        <td
                                            class="px-6 py-4 text-xs sm:text-sm max-w-[150px] truncate font-medium text-gray-900">
                                            {{ $report['ukm_name'] }} - {{ $report['activity_name'] }}</td>
                                        <td class="px-6 py-4 hidden sm:table-cell">{{ $report['level'] }} /
                                            {{ $report['position'] }}</td>
                                        <td class="px-6 py-4 hidden md:table-cell text-gray-600">
                                            {{ \Carbon\Carbon::parse($report['start_date'])->format('d M Y') }}</td>
                                        <td class="px-6 py-4 hidden sm:table-cell">
                                            @if ($report['bukti_url'] != 'Tidak Ada' && $report['bukti_url'])
                                                <a href="{{ $report['bukti_url'] }}" target="_blank"
                                                    class="text-[#09697E] hover:text-[#075263] hover:underline flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                        </path>
                                                    </svg>
                                                    Lihat
                                                </a>
                                            @else
                                                <span class="text-gray-400">Tidak Ada</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 hidden md:table-cell font-semibold text-[#E8BE00]">
                                            {{ $report['points' ?? '-'] }}
                                        </td>
                                        <td class="px-6 py-4 hidden sm:table-cell">
                                            @include('components.status-badge', [
                                                'status' => $report['status'],
                                            ])
                                        </td>
                                        <td class="px-6 py-4 text-center hidden sm:table-cell">
                                            <a href="#editModal-organization-activities-{{ $report['id'] }}"
                                                class="text-[#09697E] hover:text-[#075263] bg-cyan-50 hover:bg-cyan-100 p-2 rounded-lg transition inline-flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 text-center sm:hidden">
                                            <a href="#detailModal-organization-activities-{{ $report['id'] }}"
                                                class="text-[#09697E] bg-cyan-50 hover:bg-cyan-100 px-3 py-1 rounded-md text-xs font-medium transition">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center">
                        <p class="text-gray-500 italic">Tidak ada kegiatan organisasi yang dilaporkan.</p>
                    </div>
                @endif
            </div>
            @if (count($organizationActivities) > 0)
                @foreach ($organizationActivities as $report)
                    @include('components.modal-laporan-admin', [
                        'report' => $report,
                        'type' => 'organization-activities',
                        'modalId' => 'editModal-organization-activities-' . $report['id'],
                    ])
                    {{-- Modal Detail Mobile --}}
                    @include('components.detail-mobile-modal', [
                        'report' => $report,
                        'modalId' => 'detailModal-organization-activities-' . $report['id'],
                        'type' => 'organization-activities',
                        'fields' => [
                            'UKM' => $report['ukm_name'],
                            'Kegiatan' => $report['activity_name'],
                            'Tingkat' => $report['level'],
                            'Posisi' => $report['position'],
                            'Tanggal Mulai' => \Carbon\Carbon::parse($report['start_date'])->format('d M Y'),
                            'Points' => $report['points'] ?? '-',
                            'Status' => $report['status'],
                            'Bukti' => $report['bukti_url'],
                        ],
                    ])
                @endforeach
            @endif

            {{-- Sub-bagian: Kegiatan Kepanitiaan Atau Penugasan --}}
            @php
                $committeeActivities = $committeeActivities ?? [];
            @endphp
            <h3 class="text-lg font-semibold text-gray-600 my-6 border-l-4 border-cyan-500 pl-3">Kegiatan Kepanitiaan Atau
                Penugasan</h3>
            @if (count($committeeActivities) > 0)
                <div class="overflow-x-auto shadow-xl rounded-lg border">
                    <table class="min-w-full text-sm text-left text-gray-700 bg-white">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-4 py-3">#</th>
                                <th scope="col" class="px-4 py-3">Kegiatan</th>
                                <th scope="col" class="px-4 py-3 hidden sm:table-cell">Tipe/Tingkat</th>
                                <th scope="col" class="px-4 py-3 hidden md:table-cell">Keikutsertaan</th>
                                <th scope="col" class="px-4 py-3 hidden sm:table-cell">Bukti</th>
                                <th scope="col" class="px-4 py-3 hidden md:table-cell">Points</th>
                                <th scope="col" class="px-4 py-3 hidden sm:table-cell">Status</th>
                                <th scope="col" class="px-4 py-3 text-center hidden sm:table-cell">Aksi</th>
                                <th scope="col" class="px-4 py-3 text-center sm:hidden">Detail</th>
                                {{-- Kolom Detail Mobile --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($committeeActivities as $report)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-4 font-medium text-gray-900">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4 text-xs sm:text-sm max-w-[150px] truncate">
                                        {{ $report['activity_name'] }}</td>
                                    <td class="px-4 py-4 hidden sm:table-cell">{{ $report['activity_type'] }} /
                                        {{ $report['level'] }}</td>
                                    <td class="px-4 py-4 hidden md:table-cell">{{ $report['participation'] }}</td>
                                    <td class="px-4 py-4 hidden sm:table-cell">
                                        @if ($report['bukti_url'] != 'Tidak Ada' && $report['bukti_url'])
                                            <a href="{{ $report['bukti_url'] }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-800 hover:underline">Lihat</a>
                                        @else
                                            <span>Tidak Ada</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 hidden md:table-cell">
                                        {{ $report['points' ?? '-'] }}
                                    </td>
                                    <td class="px-4 py-4 hidden sm:table-cell">
                                        @include('components.status-badge', [
                                            'status' => $report['status'],
                                        ])
                                    </td>
                                    <td class="px-4 py-4 text-center hidden sm:table-cell">
                                        <a href="#editModal-committee-activities-{{ $report['id'] }}"
                                            class="text-indigo-600 hover:text-indigo-900 font-medium bg-indigo-100 rounded-md py-1 px-3 hover:bg-indigo-200 transition">
                                            Edit
                                        </a>
                                    </td>
                                    <td class="px-4 py-4 text-center sm:hidden"> {{-- Tombol Detail Mobile --}}
                                        <a href="#detailModal-committee-activities-{{ $report['id'] }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium bg-blue-100 rounded-md py-1 px-3 hover:bg-blue-200 transition text-xs">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 italic p-4 bg-white rounded-lg border">Tidak ada kegiatan kepanitiaan/penugasan
                    yang dilaporkan.</p>
            @endif
            @if (count($committeeActivities) > 0)
                @foreach ($committeeActivities as $report)
                    @include('components.modal-laporan-admin', [
                        'report' => $report,
                        'type' => 'committee-activities',
                        'modalId' => 'editModal-committee-activities-' . $report['id'],
                    ])
                    {{-- Modal Detail Mobile --}}
                    @include('components.detail-mobile-modal', [
                        'report' => $report,
                        'modalId' => 'detailModal-committee-activities-' . $report['id'],
                        'type' => 'committee-activities',
                        'fields' => [
                            'Kegiatan' => $report['activity_name'],
                            'Tipe Kegiatan' => $report['activity_type'],
                            'Tingkat' => $report['level'],
                            'Keikutsertaan' => $report['participation'],
                            'Points' => $report['points'] ?? '-',
                            'Status' => $report['status'],
                            'Bukti' => $report['bukti_url'],
                        ],
                    ])
                @endforeach
            @endif

            {{-- Sub-bagian: Prestasi Mahasiswa --}}
            @php
                $studentAchievements = $studentAchievements ?? [];
            @endphp
            <h3 class="text-lg font-semibold text-gray-600 my-6 border-l-4 border-cyan-500 pl-3">Prestasi Mahasiswa</h3>
            @if (count($studentAchievements) > 0)
                <div class="overflow-x-auto shadow-xl rounded-lg border">
                    <table class="min-w-full text-sm text-left text-gray-700 bg-white">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-4 py-3">#</th>
                                <th scope="col" class="px-4 py-3">Prestasi</th>
                                <th scope="col" class="px-4 py-3 hidden sm:table-cell">Tipe/Raihan</th>
                                <th scope="col" class="px-4 py-3 hidden md:table-cell">Tingkat/Tempat</th>
                                <th scope="col" class="px-4 py-3 hidden sm:table-cell">Bukti</th>
                                <th scope="col" class="px-4 py-3 hidden md:table-cell">Points</th>
                                <th scope="col" class="px-4 py-3 hidden sm:table-cell">Status</th>
                                <th scope="col" class="px-4 py-3 text-center hidden sm:table-cell">Aksi</th>
                                <th scope="col" class="px-4 py-3 text-center sm:hidden">Detail</th>
                                {{-- Kolom Detail Mobile --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($studentAchievements as $report)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-4 font-medium text-gray-900">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4 text-xs sm:text-sm max-w-[150px] truncate">
                                        {{ $report['achievements_name'] }}</td>
                                    <td class="px-4 py-4 hidden sm:table-cell">{{ $report['achievements_type'] }} /
                                        {{ $report['award'] }}</td>
                                    <td class="px-4 py-4 hidden md:table-cell">{{ $report['level'] }} /
                                        {{ $report['place'] }}</td>
                                    <td class="px-4 py-4 hidden sm:table-cell">
                                        @if ($report['bukti_url'] != 'Tidak Ada' && $report['bukti_url'])
                                            <a href="{{ $report['bukti_url'] }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-800 hover:underline">Lihat</a>
                                        @else
                                            <span>Tidak Ada</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 hidden md:table-cell">
                                        {{ $report['points' ?? '-'] }}
                                    </td>
                                    <td class="px-4 py-4 hidden sm:table-cell">
                                        @include('components.status-badge', [
                                            'status' => $report['status'],
                                        ])
                                    </td>
                                    <td class="px-4 py-4 text-center hidden sm:table-cell">
                                        <a href="#editModal-student-achievements-{{ $report['id'] }}"
                                            class="text-indigo-600 hover:text-indigo-900 font-medium bg-indigo-100 rounded-md py-1 px-3 hover:bg-indigo-200 transition">
                                            Edit
                                        </a>
                                    </td>
                                    <td class="px-4 py-4 text-center sm:hidden"> {{-- Tombol Detail Mobile --}}
                                        <a href="#detailModal-student-achievements-{{ $report['id'] }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium bg-blue-100 rounded-md py-1 px-3 hover:bg-blue-200 transition text-xs">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 italic p-4 bg-white rounded-lg border">Tidak ada prestasi mahasiswa yang
                    dilaporkan.</p>
            @endif
            @if (count($studentAchievements) > 0)
                @foreach ($studentAchievements as $report)
                    @include('components.modal-laporan-admin', [
                        'report' => $report,
                        'type' => 'student-achievements',
                        'modalId' => 'editModal-student-achievements-' . $report['id'],
                    ])
                    {{-- Modal Detail Mobile --}}
                    @include('components.detail-mobile-modal', [
                        'report' => $report,
                        'modalId' => 'detailModal-student-achievements-' . $report['id'],
                        'type' => 'student-achievements',
                        'fields' => [
                            'Prestasi' => $report['achievements_name'],
                            'Tipe' => $report['achievements_type'],
                            'Raihan' => $report['award'],
                            'Tingkat' => $report['level'],
                            'Tempat' => $report['place'],
                            'Points' => $report['points'] ?? '-',
                            'Status' => $report['status'],
                            'Bukti' => $report['bukti_url'],
                        ],
                    ])
                @endforeach
            @endif

            {{-- Sub-bagian: Kegiatan Mandiri Mahasiswa Selama Satu Semester --}}
            @php
                $independentActivities = $independentActivities ?? [];
            @endphp
            <h3 class="text-lg font-semibold text-gray-600 my-6 border-l-4 border-cyan-500 pl-3">Kegiatan Mandiri Mahasiswa
            </h3>
            @if (count($independentActivities) > 0)
                <div class="overflow-x-auto shadow-xl rounded-lg border">
                    <table class="min-w-full text-sm text-left text-gray-700 bg-white">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-4 py-3">#</th>
                                <th scope="col" class="px-4 py-3">Kegiatan</th>
                                <th scope="col" class="px-4 py-3 hidden sm:table-cell">Tipe/Partisipasi</th>
                                <th scope="col" class="px-4 py-3 hidden md:table-cell">Tanggal</th>
                                <th scope="col" class="px-4 py-3 hidden sm:table-cell">Bukti</th>
                                <th scope="col" class="px-4 py-3 hidden md:table-cell">Points</th>
                                <th scope="col" class="px-4 py-3 hidden sm:table-cell">Status</th>
                                <th scope="col" class="px-4 py-3 text-center hidden sm:table-cell">Aksi</th>
                                <th scope="col" class="px-4 py-3 text-center sm:hidden">Detail</th>
                                {{-- Kolom Detail Mobile --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($independentActivities as $report)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-4 font-medium text-gray-900">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4 text-xs sm:text-sm max-w-[150px] truncate">
                                        {{ $report['activity_name'] }}</td>
                                    <td class="px-4 py-4 hidden sm:table-cell">{{ $report['activity_type'] }} /
                                        {{ $report['participation'] }}</td>
                                    <td class="px-4 py-4 hidden md:table-cell">
                                        {{ \Carbon\Carbon::parse($report['start_date'])->format('d M Y') }}</td>
                                    <td class="px-4 py-4 hidden sm:table-cell">
                                        @if ($report['bukti_url'] != 'Tidak Ada' && $report['bukti_url'])
                                            <a href="{{ $report['bukti_url'] }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-800 hover:underline">Lihat</a>
                                        @else
                                            <span>Tidak Ada</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 hidden md:table-cell">
                                        {{ $report['points' ?? '-'] }}
                                    </td>
                                    <td class="px-4 py-4 hidden sm:table-cell">
                                        @include('components.status-badge', [
                                            'status' => $report['status'],
                                        ])
                                    </td>
                                    <td class="px-4 py-4 text-center hidden sm:table-cell">
                                        <a href="#editModal-independent-activities-{{ $report['id'] }}"
                                            class="text-indigo-600 hover:text-indigo-900 font-medium bg-indigo-100 rounded-md py-1 px-3 hover:bg-indigo-200 transition">
                                            Edit
                                        </a>
                                    </td>
                                    <td class="px-4 py-4 text-center sm:hidden"> {{-- Tombol Detail Mobile --}}
                                        <a href="#detailModal-independent-activities-{{ $report['id'] }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium bg-blue-100 rounded-md py-1 px-3 hover:bg-blue-200 transition text-xs">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 italic p-4 bg-white rounded-lg border">Tidak ada kegiatan mandiri yang dilaporkan.
                </p>
            @endif
            @if (count($independentActivities) > 0)
                @foreach ($independentActivities as $report)
                    @include('components.modal-laporan-admin', [
                        'report' => $report,
                        'type' => 'independent-activities',
                        'modalId' => 'editModal-independent-activities-' . $report['id'],
                    ])
                    {{-- Modal Detail Mobile --}}
                    @include('components.detail-mobile-modal', [
                        'report' => $report,
                        'modalId' => 'detailModal-independent-activities-' . $report['id'],
                        'type' => 'independent-activities',
                        'fields' => [
                            'Kegiatan' => $report['activity_name'],
                            'Tipe' => $report['activity_type'],
                            'Partisipasi' => $report['participation'],
                            'Tanggal' => \Carbon\Carbon::parse($report['start_date'])->format('d M Y'),
                            'Points' => $report['points'] ?? '-',
                            'Status' => $report['status'],
                            'Bukti' => $report['bukti_url'],
                        ],
                    ])
                @endforeach
            @endif
        </section>

        <hr class="my-8 border-gray-300">

        {{-- Bagian C: Evaluasi (Tidak ada tabel, hanya perlu tombol edit di bagian bawah) --}}
        <section class="mb-10">
            <h2 class="text-2xl font-extrabold text-gray-800 mb-6">C. EVALUASI (REALISASI)</h2>
            @php
                $evaluations = $evaluations ?? [];
                $evaluations = $evaluations ?? [null];
                $report = $evaluations[0] ?? [
                    'support_factors' => '-',
                    'barrier_factors' => '-',
                    'status' => 'Pending',
                    'id' => 'eval',
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Faktor Pendukung --}}
                <div class="w-full">
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">Faktor Pendukung</h3>
                    <div
                        class="p-4 bg-gray-50 border border-gray-200 rounded-xl shadow-inner min-h-[150px] text-gray-800 whitespace-pre-wrap">
                        {{ $report['support_factors'] ?? '-' }}
                    </div>
                </div>

                {{-- Faktor Penghambat --}}
                <div class="w-full">
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">Faktor Penghambat</h3>
                    <div
                        class="p-4 bg-gray-50 border border-gray-200 rounded-xl shadow-inner min-h-[150px] text-gray-800 whitespace-pre-wrap">
                        {{ $report['barrier_factors'] ?? '-' }}
                    </div>
                </div>
            </div>

            @if (count($evaluations) > 0)
                <div class="flex items-center pt-4 gap-4">
                    <h4 class="text-base font-semibold text-gray-700">Status Evaluasi:</h4>
                    @include('components.status-badge', ['status' => $report['status']])
                    <a href="#editModal-evaluations-{{ $report['id'] }}"
                        class="font-medium bg-indigo-100 rounded-lg py-2 px-4 hover:bg-indigo-400 hover:text-white transition">
                        Edit Status
                    </a>
                </div>
            @endif

            @if (count($evaluations) > 0)
                @include('components.modal-laporan-admin', [
                    'report' => $report,
                    'type' => 'evaluations',
                    'modalId' => 'editModal-evaluations-' . $report['id'],
                ])
            @endif
        </section>

        <hr class="my-8 border-gray-300">

        {{-- Bagian D: Target Semester Depan --}}
        <section class="mb-10">
            <h2 class="text-2xl font-extrabold text-gray-800 mb-6">D. TARGET SEMESTER DEPAN (Rencana)</h2>

            {{-- Sub-bagian: Rencana Nilai IPS dan IPK Semester Depan --}}
            @php
                $targetNextSemester = $targetNextSemester ?? [];
            @endphp
            <h3 class="text-lg font-semibold text-gray-600 mb-4 border-l-4 border-cyan-500 pl-3">Rencana Nilai IPS dan IPK
            </h3>
            <div class="overflow-x-auto shadow-xl rounded-lg border">
                <table class="min-w-full text-sm text-left text-gray-700 bg-white">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="px-4 py-3 sm:px-6">Semester</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 hidden md:table-cell">Target IPS</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 hidden md:table-cell">Target IPK</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 hidden md:table-cell">Status</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 text-center hidden md:table-cell">Aksi</th>
                            <th scope="col" class="px-4 py-3 text-center md:hidden">Detail</th> {{-- Kolom Detail Mobile --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($targetNextSemester as $report)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-4 sm:px-6 font-medium text-gray-900">{{ $report['semester'] }}</td>
                                <td class="px-4 py-4 sm:px-6 hidden md:table-cell">{{ $report['target_ips'] }}</td>
                                <td class="px-4 py-4 sm:px-6 hidden md:table-cell">{{ $report['target_ipk'] }}</td>
                                <td class="px-4 py-4 sm:px-6 hidden md:table-cell">
                                    @include('components.status-badge', ['status' => $report['status']])
                                </td>
                                <td class="px-4 py-4 sm:px-6 text-center hidden md:table-cell">
                                    <a href="#editModal-target-reports-{{ $report['id'] }}"
                                        class="text-indigo-600 hover:text-indigo-900 font-medium bg-indigo-100 rounded-md py-1 px-3 hover:bg-indigo-200 transition">
                                        Edit
                                    </a>
                                </td>
                                <td class="px-4 py-4 text-center md:hidden"> {{-- Tombol Detail Mobile --}}
                                    <a href="#detailModal-target-reports-{{ $report['id'] }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium bg-blue-100 rounded-md py-1 px-3 hover:bg-blue-200 transition text-xs">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if (count($targetNextSemester) > 0)
                @foreach ($targetNextSemester as $report)
                    @include('components.modal-laporan-admin', [
                        'report' => $report,
                        'type' => 'target-reports',
                        'modalId' => 'editModal-target-reports-' . $report['id'],
                    ])
                    {{-- Modal Detail Mobile --}}
                    @include('components.detail-mobile-modal', [
                        'report' => $report,
                        'modalId' => 'detailModal-target-reports-' . $report['id'],
                        'type' => 'target-reports',
                        'fields' => [
                            'Semester' => $report['semester'],
                            'Target IPS' => $report['target_ips'],
                            'Target IPK' => $report['target_ipk'],
                            'Status' => $report['status'],
                        ],
                    ])
                @endforeach
            @endif

            {{-- Rencana Kegiatan Akademik --}}
            @php $targetAcademicActivities = $targetAcademicActivities ?? []; @endphp
            <h3 class="text-lg font-semibold text-gray-600 my-6 border-l-4 border-cyan-500 pl-3">Rencana Kegiatan Akademik
            </h3>
            @if (count($targetAcademicActivities) > 0)
                <div class="overflow-x-auto shadow-xl rounded-lg border">
                    <table class="min-w-full text-sm text-left text-gray-700 bg-white">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-4 py-3">#</th>
                                <th scope="col" class="px-4 py-3">Kegiatan</th>
                                <th scope="col" class="px-4 py-3 hidden sm:table-cell">Rencana/Strategi</th>
                                <th scope="col" class="px-4 py-3 hidden sm:table-cell">Status</th>
                                <th scope="col" class="px-4 py-3 text-center hidden sm:table-cell">Aksi</th>
                                <th scope="col" class="px-4 py-3 text-center sm:hidden">Detail</th>
                                {{-- Kolom Detail Mobile --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($targetAcademicActivities as $report)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-4 font-medium text-gray-900">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4 text-xs sm:text-sm max-w-[150px] truncate">
                                        {{ $report['activity_name'] }}</td>
                                    <td class="px-4 py-4 hidden sm:table-cell max-w-[200px] truncate">
                                        {{ $report['strategy'] }}</td>
                                    <td class="px-4 py-4 hidden sm:table-cell">
                                        @include('components.status-badge', [
                                            'status' => $report['status'],
                                        ])
                                    </td>
                                    <td class="px-4 py-4 text-center hidden sm:table-cell">
                                        <a href="#editModal-target-activities-{{ $report['id'] }}"
                                            class="text-indigo-600 hover:text-indigo-900 font-medium bg-indigo-100 rounded-md py-1 px-3 hover:bg-indigo-200 transition">Edit</a>
                                    </td>
                                    <td class="px-4 py-4 text-center sm:hidden"> {{-- Tombol Detail Mobile --}}
                                        <a href="#detailModal-target-activities-{{ $report['id'] }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium bg-blue-100 rounded-md py-1 px-3 hover:bg-blue-200 transition text-xs">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 italic p-4 bg-white rounded-lg border">Tidak ada rencana kegiatan akademik.</p>
            @endif
            @if (count($targetAcademicActivities) > 0)
                @foreach ($targetAcademicActivities as $report)
                    @include('components.modal-laporan-admin', [
                        'report' => $report,
                        'type' => 'target-activities',
                        'modalId' => 'editModal-target-activities-' . $report['id'],
                    ])
                    {{-- Modal Detail Mobile --}}
                    @include('components.detail-mobile-modal', [
                        'report' => $report,
                        'modalId' => 'detailModal-target-activities-' . $report['id'],
                        'type' => 'target-activities',
                        'fields' => [
                            'Kegiatan' => $report['activity_name'],
                            'Rencana/Strategi' => $report['strategy'],
                            'Status' => $report['status'],
                        ],
                    ])
                @endforeach
            @endif

            {{-- Rencana Prestasi Mahasiswa --}}
            @php $targetAchievements = $targetAchievements ?? []; @endphp
            <h3 class="text-lg font-semibold text-gray-600 my-6 border-l-4 border-cyan-500 pl-3">Rencana Prestasi Mahasiswa
            </h3>
            @if (count($targetAchievements) > 0)
                <div class="overflow-x-auto shadow-xl rounded-lg border">
                    <table class="min-w-full text-sm text-left text-gray-700 bg-white">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-4 py-3">#</th>
                                <th scope="col" class="px-4 py-3">Prestasi</th>
                                <th scope="col" class="px-4 py-3 hidden sm:table-cell">Tingkat/Raihan</th>
                                <th scope="col" class="px-4 py-3 hidden sm:table-cell">Status</th>
                                <th scope="col" class="px-4 py-3 text-center hidden sm:table-cell">Aksi</th>
                                <th scope="col" class="px-4 py-3 text-center sm:hidden">Detail</th>
                                {{-- Kolom Detail Mobile --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($targetAchievements as $report)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-4 font-medium text-gray-900">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4 text-xs sm:text-sm max-w-[150px] truncate">
                                        {{ $report['achievements_name'] }}</td>
                                    <td class="px-4 py-4 hidden sm:table-cell">{{ $report['level'] }} /
                                        {{ $report['award'] }}</td>
                                    <td class="px-4 py-4 hidden sm:table-cell">
                                        @include('components.status-badge', [
                                            'status' => $report['status'],
                                        ])
                                    </td>
                                    <td class="px-4 py-4 text-center hidden sm:table-cell">
                                        <a href="#editModal-target-achievements-{{ $report['id'] }}"
                                            class="text-indigo-600 hover:text-indigo-900 font-medium bg-indigo-100 rounded-md py-1 px-3 hover:bg-indigo-200 transition">Edit</a>
                                    </td>
                                    <td class="px-4 py-4 text-center sm:hidden"> {{-- Tombol Detail Mobile --}}
                                        <a href="#detailModal-target-achievements-{{ $report['id'] }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium bg-blue-100 rounded-md py-1 px-3 hover:bg-blue-200 transition text-xs">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 italic p-4 bg-white rounded-lg border">Tidak ada rencana prestasi.</p>
            @endif
            @if (count($targetAchievements) > 0)
                @foreach ($targetAchievements as $report)
                    @include('components.modal-laporan-admin', [
                        'report' => $report,
                        'type' => 'target-achievements',
                        'modalId' => 'editModal-target-achievements-' . $report['id'],
                    ])
                    {{-- Modal Detail Mobile --}}
                    @include('components.detail-mobile-modal', [
                        'report' => $report,
                        'modalId' => 'detailModal-target-achievements-' . $report['id'],
                        'type' => 'target-achievements',
                        'fields' => [
                            'Prestasi' => $report['achievements_name'],
                            'Tingkat' => $report['level'],
                            'Raihan' => $report['award'],
                            'Status' => $report['status'],
                        ],
                    ])
                @endforeach
            @endif

            {{-- Rencana Kegiatan Mandiri --}}
            @php $targetIdependentActivities = $targetIdependentActivities ?? []; @endphp
            <h3 class="text-lg font-semibold text-gray-600 my-6 border-l-4 border-cyan-500 pl-3">Rencana Kegiatan Mandiri
            </h3>
            @if (count($targetIdependentActivities) > 0)
                <div class="overflow-x-auto shadow-xl rounded-lg border">
                    <table class="min-w-full text-sm text-left text-gray-700 bg-white">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-4 py-3">#</th>
                                <th scope="col" class="px-4 py-3">Kegiatan</th>
                                <th scope="col" class="px-4 py-3 hidden sm:table-cell">Partisipasi</th>
                                <th scope="col" class="px-4 py-3 hidden md:table-cell">Rencana/Strategi</th>
                                <th scope="col" class="px-4 py-3 hidden sm:table-cell">Status</th>
                                <th scope="col" class="px-4 py-3 text-center hidden sm:table-cell">Aksi</th>
                                <th scope="col" class="px-4 py-3 text-center sm:hidden">Detail</th>
                                {{-- Kolom Detail Mobile --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($targetIdependentActivities as $report)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-4 font-medium text-gray-900">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4 text-xs sm:text-sm max-w-[150px] truncate">
                                        {{ $report['activity_name'] }}</td>
                                    <td class="px-4 py-4 hidden sm:table-cell">{{ $report['participation'] }}</td>
                                    <td class="px-4 py-4 hidden md:table-cell max-w-[200px] truncate">
                                        {{ $report['strategy'] }}</td>
                                    <td class="px-4 py-4 hidden sm:table-cell">
                                        @include('components.status-badge', [
                                            'status' => $report['status'],
                                        ])
                                    </td>
                                    <td class="px-4 py-4 text-center hidden sm:table-cell">
                                        <a href="#editModal-target-independent-{{ $report['id'] }}"
                                            class="text-indigo-600 hover:text-indigo-900 font-medium bg-indigo-100 rounded-md py-1 px-3 hover:bg-indigo-200 transition">Edit</a>
                                    </td>
                                    <td class="px-4 py-4 text-center sm:hidden"> {{-- Tombol Detail Mobile --}}
                                        <a href="#detailModal-target-independent-{{ $report['id'] }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium bg-blue-100 rounded-md py-1 px-3 hover:bg-blue-200 transition text-xs">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 italic p-4 bg-white rounded-lg border">Tidak ada rencana kegiatan mandiri.</p>
            @endif
            @if (count($targetIdependentActivities) > 0)
                @foreach ($targetIdependentActivities as $report)
                    @include('components.modal-laporan-admin', [
                        'report' => $report,
                        'type' => 'target-independent',
                        'modalId' => 'editModal-target-independent-' . $report['id'],
                    ])
                    {{-- Modal Detail Mobile --}}
                    @include('components.detail-mobile-modal', [
                        'report' => $report,
                        'modalId' => 'detailModal-target-independent-' . $report['id'],
                        'type' => 'target-independent',
                        'fields' => [
                            'Kegiatan' => $report['activity_name'],
                            'Partisipasi' => $report['participation'],
                            'Rencana/Strategi' => $report['strategy'],
                            'Status' => $report['status'],
                        ],
                    ])
                @endforeach
            @endif
        </section>

        <hr class="my-8 border-gray-300">

        {{-- Form Final Aksi Admin --}}
        <div class="bg-white p-6 rounded-xl shadow-2xl border border-indigo-100">
            <h3 class="text-xl font-bold text-indigo-700 mb-4">Finalisasi Status Laporan</h3>
            <form action="/admin/laporan/{{ $laporan->laporan_id }}" method="POST" class="space-y-4">
                @csrf
                @method('put')
                <label for="final_status" class="block text-sm font-medium text-gray-700">Ubah Status Beasiswa
                    Final:</label>
                <select name="status" id="final_status"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                    <option value="Draft" {{ $laporan->status == 'Draft' ? 'selected' : '' }}
                        class="text-center bg-white text-gray-700">Draft</option>
                    <option value="Pending" {{ $laporan->status == 'Pending' ? 'selected' : '' }}
                        class="text-center bg-white text-gray-700">Pending</option>
                    <option value="Ditolak SP-1" {{ $laporan->status == 'Ditolak SP-1' ? 'selected' : '' }}
                        class="text-center bg-white text-red-600">Ditolak SP-1</option>
                    <option value="Ditolak SP-2" {{ $laporan->status == 'Ditolak SP-2' ? 'selected' : '' }}
                        class="text-center bg-white text-red-600">Ditolak SP-2</option>
                    <option value="Ditolak SP-3" {{ $laporan->status == 'Ditolak SP-3' ? 'selected' : '' }}
                        class="text-center bg-white text-red-600">Ditolak SP-3</option>
                    <option value="Lolos dengan penugasan"
                        {{ $laporan->status == 'Lolos dengan penugasan' ? 'selected' : '' }}
                        class="text-center bg-white text-orange-600">Lolos dengan penugasan</option>
                    <option value="Lolos" {{ $laporan->status == 'Lolos' ? 'selected' : '' }}
                        class="text-center bg-white text-green-600">Lolos</option>
                </select>
                <button type="submit"
                    class="w-full p-3 bg-indigo-600 hover:bg-indigo-700 transition duration-300 text-white font-semibold rounded-lg shadow-lg transform hover:scale-[1.01]">
                    Simpan & Finalisasi Status
                </button>
            </form>
        </div>

    </div>
@endsection

<style>
    /* Styling Modal dari kode asli (dibiarkan untuk memastikan fungsionalitas modal tetap berjalan) */
    .modal-target {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 50;
        /* Z-index tinggi */
        background-color: rgba(0, 0, 0, 0.5);
        /* Overlay gelap */
        display: flex;
        align-items: center;
        justify-content: center;

        visibility: hidden;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    /* Target modal akan terlihat saat hash URL cocok */
    :target {
        visibility: visible;
        opacity: 1;
        pointer-events: auto;
    }



    /* 1C: Pastikan modal tersembunyi secara default di mobile (sebelum di-target) */
    @media (max-width: 639px) {
        .modal-target:not(:target) {
            display: none !important;
        }
    }

    /* Perbaikan kecil pada tampilan tabel untuk responsifitas yang lebih baik */
    .overflow-x-auto table {
        table-layout: auto;
    }
</style>

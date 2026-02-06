@extends('mahasiswa.layout')

@section('title', 'Detail Laporan Monev')

@section('content')
    <div class="mb-6 flex justify-between items-start">
        <div>
            <h1 class="font-bold text-3xl text-gray-800">Detail Laporan Monev</h1>
            <p class="text-gray-600 mt-1">Informasi detail mengenai laporan monitoring dan evaluasi.</p>
        </div>
        @if (in_array(strtolower($laporan->status), ['lolos', 'approved']))
            <div class="flex gap-2">
                <a href="{{ route('mahasiswa.laporan.export-pdf', $laporan->laporan_id) }}"
                    class="px-4 py-2 bg-red-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-sm hover:shadow transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Export PDF
                </a>

            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 gap-6">
        {{-- Info Card --}}
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="h-2 bg-[#09697E]"></div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-50 rounded-lg text-[#09697E]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 007-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nama Mahasiswa</p>
                            <p class="font-semibold text-gray-800">{{ $dataMahasiswa->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-50 rounded-lg text-[#09697E]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">NIM</p>
                            <p class="font-semibold text-gray-800">{{ $dataMahasiswa->nim }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-50 rounded-lg text-[#09697E]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Periode</p>
                            <p class="font-semibold text-gray-800">{{ $laporan->periodeSemester?->tahun_akademik }}
                                {{ $laporan->periodeSemester?->semester }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-50 rounded-lg text-[#09697E]">
                            <svg viewBox="0 0 24 24" version="1.1" class="w-[20px] h-[20px]"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <title></title>
                                    <g fill="none" fill-rule="evenodd" id="页面-1" stroke="none"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1">
                                        <g id="导航图标" stroke="#09697E" stroke-width="1.5"
                                            transform="translate(-28.000000, -272.000000)">
                                            <g id="学术" transform="translate(28.000000, 272.000000)">
                                                <g id="编组" transform="translate(1.000000, 4.000000)">
                                                    <polygon id="路径" points="0 2.75 11 0 22 2.75 11 5.5"></polygon>
                                                    <path
                                                        d="M4.95,4.4 L4.95,9.88383 C4.95,9.88383 7.7,11.55 11,11.55 C14.3,11.55 17.05,9.88383 17.05,9.88383 L17.05,4.4"
                                                        id="路径"></path>
                                                    <line id="路径" x1="1.65" x2="1.65" y1="3.3"
                                                        y2="15.4">
                                                    </line>
                                                    <rect height="3.3" id="矩形" width="3.3" x="0" y="14.3">
                                                    </rect>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Semester Ke</p>
                            <p class="font-semibold text-gray-800">{{ $laporan->semester }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-50 rounded-lg text-[#09697E]">
                            <svg fill="#000000" viewBox="0 0 24 24" class="w-[20px] h-[20px]" id="date-check"
                                data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path id="primary"
                                        d="M20,21H4a1,1,0,0,1-1-1V9H21V20A1,1,0,0,1,20,21ZM21,5a1,1,0,0,0-1-1H4A1,1,0,0,0,3,5V9H21Z"
                                        style="fill: none; stroke: #09697E; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                                    </path>
                                    <path id="secondary" d="M16,3V6M8,3V6"
                                        style="fill: none; stroke: #09697E; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                                    </path>
                                    <polyline id="secondary-2" data-name="secondary" points="9 15 11 17 15 13"
                                        style="fill: none; stroke: #09697E; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                                    </polyline>
                                </g>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Dibuat</p>
                            <p class="font-semibold text-gray-800">{{ $laporan->created_at->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-50 rounded-lg text-[#09697E]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status Laporan</p>
                            @php
                                $warnaStatus = match ($laporan->status) {
                                    'Lolos', 'Lolos dengan penugasan' => 'bg-green-100 text-green-700 border-green-200',
                                    'Pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'Dikembalikan' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'Ditolak SP-1',
                                    'Ditolak SP-2',
                                    'Ditolak SP-3'
                                        => 'bg-red-100 text-red-700 border-red-200',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span
                                class="px-2 py-0.5 rounded text-xs font-bold
                                {{ $warnaStatus }}">
                                {{ $laporan->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tables Section --}}
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 space-y-8">

            {{-- Academic Reports --}}
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">A. Kegiatan Akademik (IPS &
                    IPK Semester ini)</h3>
                <div class="overflow-x-auto">
                    <x-tabel :headers="['No', 'Semester', 'IPS', 'IPK', 'Bukti', 'Komentar', 'Status']" :columns="['semester', 'ips', 'ipk', 'bukti', 'komentar', 'status']" :rows="$parsingAcademicReports" idKey="id" status="View"
                        style="riwayat" />
                </div>
            </div>

            {{-- Academic Activities --}}
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">Kegiatan Akademik Lainnya
                </h3>
                <div class="overflow-x-auto">
                    <x-tabel :headers="[
                        'No',
                        'Nama Kegiatan',
                        'Tipe',
                        'Partisipasi',
                        'Tempat',
                        'Mulai',
                        'Selesai',
                        'Bukti',
                        'Poin',
                        'Komentar',
                        'Status',
                    ]" :columns="[
                        'activity-name',
                        'activity-type',
                        'participation',
                        'place',
                        'start-date',
                        'end-date',
                        'bukti',
                        'point',
                        'komentar',
                        'status',
                    ]" :rows="$parsingAcademicActivities" idKey="id" status="View"
                        style="riwayat" />
                </div>
            </div>

            {{-- Organization Activities --}}
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">B. Kegiatan Non-Akademik
                    (Organisasi)</h3>
                <div class="overflow-x-auto">
                    <x-tabel :headers="[
                        'No',
                        'Nama UKM',
                        'Nama Kegiatan',
                        'Tingkat',
                        'Posisi',
                        'Tempat',
                        'Mulai',
                        'Selesai',
                        'Bukti',
                        'Poin',
                        'Komentar',
                        'Status',
                    ]" :columns="[
                        'ukm-name',
                        'activity-name',
                        'level',
                        'position',
                        'place',
                        'start-date',
                        'end-date',
                        'bukti',
                        'point',
                        'komentar',
                        'status',
                    ]" :rows="$parsingOrganizationActivities" idKey="id" status="View"
                        style="riwayat" />
                </div>
            </div>

            {{-- Committee Activities --}}
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">Kegiatan Kepanitiaan</h3>
                <div class="overflow-x-auto">
                    <x-tabel :headers="[
                        'No',
                        'Nama Kegiatan',
                        'Tipe',
                        'Partisipasi',
                        'Tingkat',
                        'Tempat',
                        'Mulai',
                        'Selesai',
                        'Bukti',
                        'Poin',
                        'Komentar',
                        'Status',
                    ]" :columns="[
                        'activity-name',
                        'activity-type',
                        'participation',
                        'level',
                        'place',
                        'start-date',
                        'end-date',
                        'bukti',
                        'point',
                        'komentar',
                        'status',
                    ]" :rows="$parsingCommitteeActivities" idKey="id" status="View"
                        style="riwayat" />
                </div>
            </div>

            {{-- Achievements --}}
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">Prestasi</h3>
                <div class="overflow-x-auto">
                    <x-tabel :headers="[
                        'No',
                        'Nama Prestasi',
                        'Tipe',
                        'Tingkat',
                        'Juara',
                        'Tempat',
                        'Mulai',
                        'Selesai',
                        'Bukti',
                        'Poin',
                        'Komentar',
                        'Status',
                    ]" :columns="[
                        'achievements-name',
                        'achievements-type',
                        'level',
                        'award',
                        'place',
                        'start-date',
                        'end-date',
                        'bukti',
                        'point',
                        'komentar',
                        'status',
                    ]" :rows="$parsingAchievements" idKey="id" status="View"
                        style="riwayat" />
                </div>
            </div>

            {{-- Independent Activities --}}
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">Kegiatan Mandiri</h3>
                <div class="overflow-x-auto">
                    <x-tabel :headers="[
                        'No',
                        'Nama Kegiatan',
                        'Tipe',
                        'Partisipasi',
                        'Tempat',
                        'Mulai',
                        'Selesai',
                        'Bukti',
                        'Poin',
                        'Komentar',
                        'Status',
                    ]" :columns="[
                        'activity-name',
                        'activity-type',
                        'participation',
                        'place',
                        'start-date',
                        'end-date',
                        'bukti',
                        'point',
                        'komentar',
                        'status',
                    ]" :rows="$parsingIndependentActivities" idKey="id" status="View"
                        style="riwayat" />
                </div>
            </div>

            {{-- Evaluasi Diri --}}
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">C. Evaluasi Diri</h3>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <p class="text-gray-700 italic">"{{ $parsingEvaluations->evaluation ?? 'Tidak ada evaluasi diri' }}"
                    </p>
                </div>
            </div>

            {{-- Rencana Semester Depan --}}
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">D. Rencana Semester Depan
                </h3>
                {{-- Target IPS/IPK --}}
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-700 mb-1">Target Akademik</h4>
                    <div class="overflow-x-auto">
                        <x-tabel :headers="['No', 'Semester', 'Target IPS', 'Target IPK', 'Status']" :columns="['semester', 'target-ips', 'target-ipk', 'status']" :rows="$parsingNextReports" idKey="id" status="View"
                            style="riwayat" />
                    </div>
                </div>

                {{-- Target Kegiatan Akademik --}}
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-700 mb-1">Rencana Kegiatan Akademik</h4>
                    <div class="overflow-x-auto">
                        <x-tabel :headers="['No', 'Nama Kegiatan', 'Strategi', 'Status']" :columns="['activity-name', 'strategy', 'status']" :rows="$parsingNextAcademicActivities" idKey="id" status="View"
                            style="riwayat" />
                    </div>
                </div>

                {{-- Target Prestasi --}}
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-700 mb-1">Rencana Prestasi</h4>
                    <div class="overflow-x-auto">
                        <x-tabel :headers="['No', 'Nama Prestasi', 'Tingkat', 'Juara', 'Status']" :columns="['achievements-name', 'level', 'award', 'status']" :rows="$parsingNextAchievements" idKey="id" status="View"
                            style="riwayat" />
                    </div>
                </div>

                {{-- Target Mandiri --}}
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-700 mb-1">Rencana Kegiatan Mandiri</h4>
                    <div class="overflow-x-auto">
                        <x-tabel :headers="['No', 'Nama Kegiatan', 'Partisipasi', 'Strategi', 'Status']" :columns="['activity-name', 'participation', 'strategy', 'status']" :rows="$parsingNextIndependentActivities" idKey="id" status="View"
                            style="riwayat" />
                    </div>
                </div>
            </div>

            {{-- Keuangan --}}
            <div x-cloak x-data="{ openKeuangan: false, openEditKeuangan: false, editDataKeuangan: {} }" class="mb-2 cursor-default"
                x-on:edit-keuangan="editDataKeuangan = $event.detail; openEditKeuangan = true">
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">E. Laporan Keuangan</h3>

                {{-- Ringkasan Total Keuangan --}}
                <div class="mb-3">
                    <div
                        class="flex items-center justify-between bg-white border-l-4 border-[#09697E] rounded-lg shadow-sm px-4 py-3">
                        <div>
                            <p class="text-sm text-gray-500">Total Keuangan</p>
                            <p class="text-xl lg:text-2xl font-bold text-[#013F4E]">
                                Rp
                                {{ $parsingLaporanKeuangan === null ? 0 : number_format($parsingLaporanKeuangan['total'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto w-full">
                    <x-tabel :headers="['No', 'Keperluan', 'Nominal', 'Status']" :columns="['keperluan', 'nominal', 'status']" :rows="$parsingLaporanKeuangan === null ? [] : $parsingLaporanKeuangan['detail']" idKey="id"
                        editEvent="edit-keuangan" deleteRoute="laporan.keuangan.hapus" :status="$laporan->status"
                        style="riwayat" />
                </div>
            </div>

            {{-- Kesan Pesan --}}
            <div x-cloak x-data="{ openKesanPesan: false, openEditKesanPesan: false, editDataKesanPesan: {} }" class="mb-2 cursor-default"
                x-on:edit-pesan-kesan="editDataKesanPesan = $event.detail; openEditKesanPesan = true">
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">F. Kesan dan Pesan Mahasiswa
                </h3>

                <div class="overflow-x-auto w-full">
                    <x-tabel :headers="['No', 'Kesan', 'Pesan', 'Status']" :columns="['kesan', 'pesan', 'status']" :rows="$parsingKesanPesan" idKey="id"
                        editEvent="edit-pesan-kesan" deleteRoute="laporan.kesan-pesan.hapus" :status="$laporan->status"
                        style="riwayat" />
                </div>
            </div>
        </div>

        <div class="mt-4 flex justify-end">
            <a href="{{ route('mahasiswa.riwayat-laporan') }}"
                class="px-5 py-2.5 bg-gray-500 text-white font-semibold rounded-lg hover:bg-gray-600 transition shadow-sm">
                Kembali ke Riwayat
            </a>
        </div>
    </div>
@endsection

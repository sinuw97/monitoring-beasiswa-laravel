@extends('mahasiswa.layout')

@section('title', 'Detail Laporan Monev')

@section('content')
    <div class="mb-6">
        <h1 class="font-bold text-3xl text-gray-800">Detail Laporan Monev</h1>
        <p class="text-gray-600 mt-1">Informasi detail mengenai laporan monitoring dan evaluasi.</p>
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status Laporan</p>
                            <span
                                class="px-2 py-0.5 rounded text-xs font-bold
                                {{ $laporan->status === 'Approved' || $laporan->status === 'Lolos'
                                    ? 'bg-green-100 text-green-700'
                                    : ($laporan->status === 'Dikembalikan'
                                        ? 'bg-red-100 text-red-700'
                                        : 'bg-yellow-100 text-yellow-700') }}">
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
                    <p class="text-gray-700 italic">"{{ $parsingEvaluations->evaluation ?? 'Tidak ada evaluasi diri' }}"</p>
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
                                Rp {{ number_format($parsingLaporanKeuangan['total'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto w-full">
                    <x-tabel :headers="['No', 'Keperluan', 'Nominal', 'Status']" :columns="['keperluan', 'nominal', 'status']" :rows="$parsingLaporanKeuangan['detail']" idKey="id"
                        editEvent="edit-keuangan" deleteRoute="laporan.keuangan.hapus" :status="$laporan->status"
                        style="riwayat" />
                </div>
            </div>

            {{-- Kesan Pesan --}}
            <div x-cloak x-data="{ openKesanPesan: false, openEditKesanPesan: false, editDataKesanPesan: {} }" class="mb-2 cursor-default"
                x-on:edit-pesan-kesan="editDataKesanPesan = $event.detail; openEditKesanPesan = true">
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">F. Kesan dan Pesan Mahasiswa</h3>

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

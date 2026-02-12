@extends('mahasiswa.layout')

@section('title', 'Isi Laporan Monev')

@section('content')
    <div class="mb-8">
        <h1 class="font-bold text-3xl text-gray-900 tracking-tight">Laporan Monev</h1>
        <p class="text-gray-500 mt-2 text-lg">Kelola dan pantau perkembangan laporan monitoring evaluasi Anda.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Nama --}}
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 007-7z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Mahasiswa</p>
                <p class="font-bold text-gray-900 text-sm truncate">{{ $dataMahasiswa->name }}</p>
            </div>
        </div>

        {{-- NIM --}}
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">NIM</p>
                <p class="font-bold text-gray-900 text-sm">{{ $dataMahasiswa->nim }}</p>
            </div>
        </div>

        {{-- Periode --}}
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="p-3 bg-purple-50 text-purple-600 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Periode</p>
                <p class="font-bold text-gray-900 text-sm">{{ $laporan->periodeSemester?->tahun_akademik }} {{ $laporan->periodeSemester?->semester }}</p>
                <p class="text-xs text-gray-500 font-medium">Semester Ke-{{ $laporan->semester }}</p>
            </div>
        </div>

        {{-- Status --}}
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="p-3 bg-green-50 text-green-600 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Status</p>
                @php
                    $warnaStatus = match ($laporan->status) {
                        'Lolos', 'Lolos dengan penugasan' => 'text-green-600 bg-green-50',
                        'Pending' => 'text-yellow-600 bg-yellow-50',
                        'Dikembalikan' => 'text-blue-600 bg-blue-50',
                        'Ditolak SP-1', 'Ditolak SP-2', 'Ditolak SP-3' => 'text-red-600 bg-red-50',
                        default => 'text-gray-600 bg-gray-50',
                    };
                @endphp
                <span class="font-bold text-sm {{ $warnaStatus }} px-2 py-0.5 rounded-md inline-block mt-0.5">
                    {{ $laporan->status }}
                </span>
                <p class="text-xs text-gray-400 mt-1">{{ $laporan->created_at->translatedFormat('d M Y') }}</p>
            </div>
        </div>
    </div>

        {{-- Informasi Penting --}}
        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-r-lg p-4 mb-6 shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        Perhatikan bahwa <span class="font-medium">tanggal mulai</span> dan <span class="font-medium">tanggal selesai</span> kegiatan harus berada dalam
                        <span class="font-medium">rentang waktu periode monev</span> yang telah ditentukan.
                    </p>
                </div>
            </div>
        </div>

        {{-- Status Periode Laporan --}}
        @if ($laporan->periodeSemester && $laporan->periodeSemester->status === 'Non-Aktif')
            <div class="bg-red-200 border-l-4 border-red-600 text-red-700 w-full px-3 py-3 rounded">
                Periode pengisian laporan sudah ditutup.
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-600 text-[#013F4E] w-full px-3 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="bg-red-200 border-l-4 border-red-600 text-red-700 w-full px-3 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-200 border-l-4 border-red-600 text-red-700 p-2 rounded mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tables Section --}}
        <div class="space-y-8">
            {{-- Reports & Academic Activities Unified Card --}}
            <div x-cloak x-data="{
                openReports: false, openEditReports: false, editDataReports: {},
                openAcademic: false, openEditAcademic: false, editDataAcademy: {}
            }"
                x-on:edit-reports.window="editDataReports = $event.detail; openEditReports = true"
                x-on:edit-academic.window="editDataAcademy = $event.detail; openEditAcademic = true"
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

                <div class="mb-6 pb-2 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">A. Kegiatan Akademik</h3>
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto w-full">
                    <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                        <h4 class="text-lg font-bold text-gray-800">1. IPS & IPK</h4>
                        @if ($laporan->status === 'Draft' && (!$parsingAcademicReports || count($parsingAcademicReports) === 0))
                            <button @click="openReports = true"
                                class="bg-[#f9d223] px-3 py-1.5 rounded-lg hover:bg-[#ffe056] transition cursor-pointer shadow-sm text-sm font-semibold text-gray-800 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Tambah
                            </button>
                        @endif
                    </div>
                    {{-- Panggil komponen tabel --}}
                    <x-tabel :headers="['No', 'Semester', 'IPS', 'IPK', 'Bukti', 'Status']" :columns="['semester', 'ips', 'ipk', 'bukti', 'status']" :rows="$parsingAcademicReports" idKey="id" editEvent="edit-reports"
                        deleteRoute="laporan.academic-reports.delete" :status="$laporan->status" style="draft" />
                </div>

                {{-- Modal --}}
                @if ($laporan->status === 'Draft')
                    @if (!$parsingAcademicReports || count($parsingAcademicReports) === 0)
                        {{-- Button moved to header --}}
                    @endif

                    {{-- Modal tambah data --}}
                    <x-modal title="Tambah data IPS dan IPK" show="openReports">
                        <form method="POST" action="{{ route('laporan.academic-reports.store', $laporan->laporan_id) }}"
                            enctype="multipart/form-data" x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Semester <span
                                        class="text-red-500">*</span></label>
                                <select name="semester"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                    <option value="{{ $laporan->semester }}">{{ $laporan->semester }}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">IPS <span class="text-red-500">*</span></label>
                                <span class="text-[2pt] text-red-500 italic">Maks 4.00</span>
                                <input type="number" name="ips" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0" step="0.01"
                                    min="0" max="4">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">IPK <span class="text-red-500">*</span></label>
                                <span class="text-[2pt] text-red-500 italic">Maks 4.00</span>
                                <input type="number" name="ipk" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0" step="0.01"
                                    min="0" max="4">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Bukti <span class="italic">(pdf, jpg,
                                        jpeg, atau png)</span>
                                    maks 5MB<span class="text-red-500">*</span></label>
                                {{-- Prod: required --}}
                                <input type="file" name="bukti" id="bukti" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openReports = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded">
                                </button>
                            </div>
                        </form>
                    </x-modal>
                    {{-- Modal edit data --}}
                    <x-modal title="Edit data IPS dan IPK" show="openEditReports">
                        <form
                            x-bind:action="'{{ route('laporan.academic-reports.update', ':id') }}'.replace(':id',
                                editDataReports
                                .id)"
                            method="POST" enctype="multipart/form-data" x-data="{ submitting: false }"
                            x-on:submit="submitting = true">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label>Semester
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="semester" x-model="editDataReports.semester"
                                    class="w-full border rounded px-2 py-1">
                                    <option value="{{ $laporan->semester }}">{{ $laporan->semester }}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>IPS <span class="text-red-500">*</span></label>
                                <input type="number" name="ips" x-model="editDataReports.ips"
                                    class="w-full border rounded px-2 py-1" step="0.01" min="0"
                                    max="4">
                            </div>
                            <div class="mb-3">
                                <label>IPK<span class="text-red-500">*</span></label>
                                <input type="number" name="ipk" x-model="editDataReports.ipk"
                                    class="w-full border rounded px-2 py-1" step="0.01" min="0"
                                    max="4">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Bukti <span class="italic">(pdf, jpg,
                                        jpeg, atau png)</span>
                                    maks 5MB<span class="text-red-500">*</span></label>
                                <input type="file" name="bukti" id="bukti" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                <div class="text-sm mt-1" x-show="editDataReports.bukti">
                                </div>
                            </div>
                            {{-- btn --}}
                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openEditReports = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">
                                    Batal
                                </button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded">
                                </button>
                            </div>
                        </form>
                    </x-modal>
                @endif
                {{-- Divider --}}
                <hr class="my-6 border-gray-100">

                {{-- Academic Activities Section --}}
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800">2. Kegiatan Akademik Lain</h4>
                    @if ($laporan->status === 'Draft')
                        <button @click="openAcademic = true"
                            class="bg-[#f9d223] px-3 py-1.5 rounded-lg hover:bg-[#ffe056] transition cursor-pointer shadow-sm text-sm font-semibold text-gray-800 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah
                        </button>
                    @endif
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto w-full">
                    <x-tabel :headers="[
                        'No',
                        'Nama Kegiatan',
                        'Tipe Kegiatan',
                        'Keikutsertaan',
                        'Tempat',
                        'Tanggal Mulai',
                        'Tanggal Selesai',
                        'Bukti',
                        'Status',
                    ]" :columns="[
                        'activity-name',
                        'activity-type',
                        'participation',
                        'place',
                        'start-date',
                        'end-date',
                        'bukti',
                        'status',
                    ]" :rows="$parsingAcademicActivities" idKey="id"
                        editEvent="edit-academic" deleteRoute="laporan.academic-activities.delete" :status="$laporan->status"
                        style="draft" />
                </div>

                {{-- Modal --}}
                @if ($laporan->status === 'Draft')

                    {{-- Tambah Modal --}}
                    <x-modal title="Tambah Data Kegiatan Akademik" show="openAcademic">
                        <form method="POST"
                            action="{{ route('laporan.academic-activities.store', $laporan->laporan_id) }}"
                            enctype="multipart/form-data" x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Kegiatan <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nama-kegiatan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tipe Kegiatan <span
                                        class="text-red-500">*</span></label>
                                <select name="tipe-kegiatan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                    <option value="" class="italic">Pilih Tipe</option>
                                    <option value="Salam Kampus">Salam Kampus</option>
                                    <option value="Social Training Camp">Social Training Camp</option>
                                    <option value="Asistensi Keagamaan">Asistensi Keagamaan</option>
                                    <option value="Program Kreativitas Mahasiswa">Program Kreativitas Mahasiswa
                                    </option>
                                    <option value="Sertifikasi Internasional Program Studi">Sertifikasi
                                        Internasional
                                        Program Studi</option>
                                    <option value="Kuliah Reguler">Kuliah Reguler</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Keikutsertaan
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="keikutsertaan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                    <option value="" class="italic">Pilih Keikutsertaan</option>
                                    <option value="Peserta">Peserta</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tempat
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tempat" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Mulai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-mulai" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Selesai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-selesai" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Bukti <span class="italic">(pdf, jpg,
                                        jpeg, atau png)</span>
                                    maks 5MB<span class="text-red-500">*</span></label>
                                </label>
                                {{-- Prod: required --}}
                                <input type="file" name="bukti" id="bukti" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openAcademic = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>

                    {{-- Edit Modal --}}
                    <x-modal title="Edit data Kegiatan Akademik" show="openEditAcademic">
                        <form method="POST"
                            x-bind:action="'{{ route('laporan.academic-activities.update', ':id') }}'.replace(':id',
                                editDataAcademy
                                .id)"
                            enctype="multipart/form-data" x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Kegiatan <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nama-kegiatan" x-model="editDataAcademy['activity-name']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tipe Kegiatan <span
                                        class="text-red-500">*</span></label>
                                <select name="tipe-kegiatan"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                    x-model="editDataAcademy['activity-type']">
                                    <option value="" class="italic">Pilih Tipe</option>
                                    <option value="Salam Kampus">Salam Kampus</option>
                                    <option value="Social Training Camp">Social Training Camp</option>
                                    <option value="Asistensi Keagamaan">Asistensi Keagamaan</option>
                                    <option value="Program Kreativitas Mahasiswa">Program Kreativitas Mahasiswa
                                    </option>
                                    <option value="Sertifikasi Internasional Program Studi">Sertifikasi
                                        Internasional
                                        Program Studi</option>
                                    <option value="Kuliah Reguler">Kuliah Reguler</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Keikutsertaan
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="keikutsertaan"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                    x-model="editDataAcademy['participation']">
                                    <option value="" class="italic">Pilih Keikutsertaan</option>
                                    <option value="Peserta">Peserta</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tempat
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tempat" x-model="editDataAcademy['place']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Mulai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-mulai" x-model="editDataAcademy['start-date']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Selesai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-selesai" x-model="editDataAcademy['end-date']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Bukti <span class="italic">(pdf, jpg,
                                        jpeg, atau png)</span>
                                    maks 5MB<span class="text-red-500">*</span></label>
                                </label>
                                <input type="file" name="bukti" id="bukti" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openEditAcademic = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>
                @endif
            </div>

            {{-- Organization, Committee, Achievement, Independent Unified Card --}}
            <div x-cloak x-data="{
                openOrganization: false, openEditOrg: false, editDataOrg: {},
                openCommittee: false, openEditCommittee: false, editDataCommittee: {},
                openAchievement: false, openEditAchievement: false, editDataAchievement: {},
                openIndependent: false, openEditIndependent: false, editDataIndependent: {}
            }"
                x-on:edit-org.window="editDataOrg = $event.detail; openEditOrg = true"
                x-on:edit-committee.window="editDataCommittee = $event.detail; openEditCommittee = true"
                x-on:edit-achievement.window="editDataAchievement = $event.detail; openEditAchievement = true"
                x-on:edit-independent.window="editDataIndependent = $event.detail; openEditIndependent = true"
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

                <div class="mb-6 pb-2 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">B. Kegiatan Non-Akademik</h3>
                </div>

                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800">1. Kegiatan Organisasi Mahasiswa</h4>
                    @if ($laporan->status === 'Draft')
                        <button @click="openOrganization = true"
                            class="bg-[#f9d223] px-3 py-1.5 rounded-lg hover:bg-[#ffe056] transition cursor-pointer shadow-sm text-sm font-semibold text-gray-800 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah
                        </button>
                    @endif
                </div>

                <div class="overflow-x-auto w-full">
                    <x-tabel :headers="[
                        'No',
                        'Nama UKM',
                        'Nama Kegiatan',
                        'Tingkat',
                        'Posisi',
                        'Tempat',
                        'Tanggal Mulai',
                        'Tanggal Selesai',
                        'Bukti',
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
                        'status',
                    ]" :rows="$parsingOrganizationActivities" idKey="id" editEvent="edit-org"
                        deleteRoute="laporan.org-activities.delete" :status="$laporan->status" style="draft" />
                </div>

                @if ($laporan->status === 'Draft')

                    {{-- Modal Tambah --}}
                    <x-modal title="Tambah data kegiatan organisasi" show="openOrganization">
                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('laporan.org-activities.store', $laporan->laporan_id) }}"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama UKM <span
                                        class="text-red-500">*</span></label>
                                <select name="nama-ukm" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                    <option value="" class="italic">Pilih UKM</option>
                                    <option value="BEM">BEM</option>
                                    <option value="ALVIC">ALVIC</option>
                                    <option value="LDK">LDK</option>
                                    <option value="PMKK">PMKK</option>
                                    <option value="PASTERA">PASTERA</option>
                                    <option value="FORVOL">FORVOL</option>
                                    <option value="KEWIRAUSAHAAN">KEWIRAUSAHAAN</option>
                                    <option value="PSM">PSM</option>
                                    <option value="CIT">CIT</option>
                                    <option value="TSU SPORT">TSU SPORT</option>
                                    <option value="ENGLISH CLUB">ENGLISH CLUB</option>
                                    <option value="KSR">KSR</option>
                                    <option value="HIMPUNAN MAHASISWA">HIMPUNAN MAHASISWA</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Kegiatan <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nama-kegiatan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tingkat
                                    <span class="text-red-500">*</span></label>
                                <select name="tingkat" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                    <option value="" class="italic">Pilih Tingkat</option>
                                    <option value="Perguruan Tinggi">Perguruan Tinggi</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Posisi <span
                                        class="text-red-500">*</span></label>
                                <select name="posisi" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                    <option value="" class="italic">Pilih Posisi</option>
                                    <option value="Ketua">Ketua</option>
                                    <option value="Wakil Ketua">Wakil Ketua</option>
                                    <option value="Sekretaris">Sekretaris</option>
                                    <option value="Divisi">Divisi</option>
                                    <option value="Anggota">Anggota</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tempat
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tempat" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Mulai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-mulai" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Selesai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-selesai" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Bukti <span class="italic">(pdf, jpg,
                                        jpeg, atau png)</span>
                                    maks 5MB<span class="text-red-500">*</span></label>
                                {{-- Prod: required --}}
                                <input type="file" name="bukti" id="bukti" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openOrganization = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>

                    {{-- Modal Edit --}}
                    <x-modal title="Edit data kegiatan organisasi" show="openEditOrg">
                        <form method="POST"
                            x-bind:action="'{{ route('laporan.org-activities.update', ':id') }}'.replace(':id', editDataOrg.id)"
                            enctype="multipart/form-data" x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama UKM <span
                                        class="text-red-500">*</span></label>
                                <select name="nama-ukm"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                    x-model="editDataOrg['ukm-name']">
                                    <option value="" class="italic">Pilih UKM</option>
                                    <option value="BEM">BEM</option>
                                    <option value="ALVIC">ALVIC</option>
                                    <option value="LDK">LDK</option>
                                    <option value="PMKK">PMKK</option>
                                    <option value="PSM">PSM</option>
                                    <option value="CIT">CIT</option>
                                    <option value="FORVOL">FORVOL</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Kegiatan <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nama-kegiatan" x-model="editDataOrg['activity-name']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tingkat <span
                                        class="text-red-500">*</span></label>
                                <select name="tingkat"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                    x-model="editDataOrg['level']">
                                    <option value="" class="italic">Pilih Tingkat</option>
                                    <option value="Perguruan Tinggi">Perguruan Tinggi</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Posisi <span
                                        class="text-red-500">*</span></label>
                                <select name="posisi"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                    x-model="editDataOrg['position']">
                                    <option value="" class="italic">Pilih Posisi</option>
                                    <option value="Ketua">Ketua</option>
                                    <option value="Wakil Ketua">Wakil Ketua</option>
                                    <option value="Sekretaris">Sekretaris</option>
                                    <option value="Divisi">Divisi</option>
                                    <option value="Anggota">Anggota</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tempat
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tempat" x-model="editDataOrg['place']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Mulai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-mulai" x-model="editDataOrg['start-date']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Selesai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-selesai" x-model="editDataOrg['end-date']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Bukti <span class="italic">(pdf, jpg,
                                        jpeg, atau png)</span>
                                    maks 5MB<span class="text-red-500">*</span></label>
                                <input type="file" name="bukti" id="bukti" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openEditOrg = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded">Simpan</button>
                            </div>
                        </form>
                    </x-modal>
                @endif
                {{-- Divider --}}
                <hr class="my-6 border-gray-100">

                {{-- Committee Activities --}}
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800">2. Kegiatan Kepanitiaan</h4>
                    @if ($laporan->status === 'Draft')
                        <button @click="openCommittee = true"
                            class="bg-[#f9d223] px-3 py-1.5 rounded-lg hover:bg-[#ffe056] transition cursor-pointer shadow-sm text-sm font-semibold text-gray-800 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah
                        </button>
                    @endif
                </div>

                <div class="overflow-x-auto w-full">
                    <x-tabel :headers="[
                        'No',
                        'Nama Kegiatan',
                        'Tipe Kegiatan',
                        'Keikutsertaan',
                        'Tingkat',
                        'Tempat',
                        'Tanggal Mulai',
                        'Tanggal Selesai',
                        'Bukti',
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
                        'status',
                    ]" :rows="$parsingCommitteeActivities" idKey="id"
                        editEvent="edit-committee" deleteRoute="laporan.committee-activities.hapus" :status="$laporan->status"
                        style="draft" />
                </div>

                @if ($laporan->status === 'Draft')

                    {{-- Modal Tambah --}}
                    <x-modal title="Tambah Data Kegiatan Penugasan dan Kepanitian" show="openCommittee">
                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('laporan.committee-activities.store', $laporan->laporan_id) }}"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Kegiatan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama-kegiatan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tipe Kegiatan
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="tipe-kegiatan" id="tipe-kegiatan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                    <option value="">Pilih Satu</option>
                                    <option value="Pelatihan Kepemimpinan">Pelatihan Kepemimpinan</option>
                                    <option value="Panitia Kegiatan Perguruan Tinggi">Panitia Kegiatan Perguruan
                                        Tinggi</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tingkat
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="tingkat" id="tingkat" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                    <option value="" class="italic">Pilih Tingkatan</option>
                                    {{-- utk Kepemimpinan --}}
                                    <option value="Pra Dasar">Pra Dasar</option>
                                    <option value="Dasar">Dasar</option>
                                    <option value="Menengah">Menengah</option>
                                    <option value="Lanjut">Lanjut</option>
                                    {{-- utk panitia --}}
                                    <option value="Internasional">Internasional</option>
                                    <option value="Nasional">Nasional</option>
                                    <option value="Regional">Regional</option>
                                    <option value="Perguruan Tinggi">Perguruan Tinggi</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Keikutsertaan
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="keikutsertaan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                    <option value="" class="italic">Pilih Posisi</option>
                                    <option value="Ketua">Ketua</option>
                                    <option value="Wakil Ketua">Wakil Ketua</option>
                                    <option value="Sekretaris">Sekretaris</option>
                                    <option value="Divisi">Divisi</option>
                                    <option value="Anggota">Anggota</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tempat
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tempat" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Mulai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-mulai" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Selesai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-selesai" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Bukti <span class="italic">(pdf, jpg,
                                        jpeg, atau png)</span>
                                    maks 5MB<span class="text-red-500">*</span></label>
                                </label>
                                {{-- Prod: required --}}
                                <input type="file" name="bukti" id="bukti" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openCommittee = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>

                    {{-- Modal Edit --}}
                    <x-modal title="Tambah Data Kegiatan Penugasan dan Kepanitian" show="openEditCommittee">
                        <form method="POST" enctype="multipart/form-data"
                            x-bind:action="'{{ route('laporan.committee-activities.update', ':id') }}'.replace(':id',
                                editDataCommittee.id)"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Kegiatan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama-kegiatan" x-model="editDataCommittee['activity-name']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tipe Kegiatan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tipe-kegiatan" id="tipe-kegiatan"
                                    x-model="editDataCommittee['activity-type']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tingkat
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tingkat" id="tingkat" x-model="editDataCommittee['level']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Keikutsertaan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="keikutsertaan" x-model="editDataCommittee['participation']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tempat
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tempat" x-model="editDataCommittee['place']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Mulai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-mulai" x-model="editDataCommittee['start-date']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Selesai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-selesai" x-model="editDataCommittee['end-date']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Bukti <span class="italic">(pdf, jpg,
                                        jpeg, atau png)</span>
                                    maks 5MB<span class="text-red-500">*</span></label>
                                </label>
                                <input type="file" name="bukti" id="bukti" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openEditCommittee = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>

                    {{-- JS (dipertahankan) --}}
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const tipeKegiatan = document.getElementById("tipe-kegiatan");
                            const tingkat = document.getElementById("tingkat");

                            const data = {
                                "Pelatihan Kepemimpinan": ["Pra Dasar", "Dasar", "Menengah", "Lanjut"],
                                "Panitia Kegiatan Perguruan Tinggi": ["Internasional", "Nasional", "Regional",
                                    "Perguruan Tinggi"
                                ]
                            };

                            tipeKegiatan.addEventListener("change", function() {
                                const value = this.value;
                                tingkat.innerHTML = '<option value="">Pilih Tingkatan</option>';

                                if (data[value]) {
                                    data[value].forEach(level => {
                                        const opt = document.createElement("option");
                                        opt.value = level;
                                        opt.textContent = level;
                                        tingkat.appendChild(opt);
                                    });
                                }
                            });
                        });
                    </script>
                @endif
                {{-- Divider --}}
                <hr class="my-6 border-gray-100">

                {{-- Achievements --}}
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800">3. Prestasi</h4>
                    @if ($laporan->status === 'Draft')
                        <button @click="openAchievement = true"
                            class="bg-[#f9d223] px-3 py-1.5 rounded-lg hover:bg-[#ffe056] transition cursor-pointer shadow-sm text-sm font-semibold text-gray-800 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah
                        </button>
                    @endif
                </div>

                <div class="overflow-x-auto w-full">
                    <x-tabel :headers="[
                        'No',
                        'Nama Prestasi',
                        'Tipe Prestasi',
                        'Tingkat',
                        'Juara',
                        'Tempat',
                        'Tanggal Mulai',
                        'Tanggal Selesai',
                        'Bukti',
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
                        'status',
                    ]" :rows="$parsingAchievements" idKey="id"
                        editEvent="edit-achievement" deleteRoute="laporan.achievements.hapus" :status="$laporan->status"
                        style="draft" />
                </div>

                @if ($laporan->status === 'Draft')

                    {{-- Modal Tambah --}}
                    <x-modal title="Tambah Data Prestasi" show="openAchievement">
                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('laporan.achievements.store', $laporan->laporan_id) }}"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Prestasi
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama-prestasi" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tipe Prestasi
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="tipe-prestasi" id="tipe-prestasi" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                    <option value="" class="italic">Pilih Tipe</option>
                                    <option value="Kompetisi Pemerintahan Individu">Kompetisi Pemerintahan Individu
                                    </option>
                                    <option value="Kompetisi Pemerintahan Kelompok">Kompetisi Pemerintahan Kelompok
                                    </option>
                                    <option value="Kompetisi Non-Pemerintahan Individu">Kompetisi Non-Pemerintahan
                                        Individu</option>
                                    <option value="Kompetisi Non-Pemerintahan Kelompok">Kompetisi Non-Pemerintahan
                                        Kelompok</option>
                                    <option value="Juri/Wasit/Pelatih">Menjadi Juri/Wasit/Pelatih</option>
                                    <option value="Anggota Dalam Penelitian/Pengabdian">Anggota Dalam
                                        Penelitian/Pengabdian</option>
                                    <option value="Kegiatan/Forum Ilmiah">Mengikuti Kegiatan/Forum Ilmiah</option>
                                    <option value="Karya Yang Didanai">Menghasilkan Karya Yang Didanai</option>
                                    <option value="Karya Populer Yang Diterbitkan">Menghasilkan Karya Populer Yang
                                        Diterbitkan</option>
                                    <option value="Penulis Buku ISBN">Penulis Buku ISBN</option>
                                    <option value="Paten/Paten Sederhana">Paten/Paten Sederhana</option>
                                    <option value="Publikasi Jurnal Internasional/Nasional">Publikasi Jurnal
                                        Internasional/Nasional Bereputasi</option>
                                    <option value="Ikut Kegiatan Sosial/Kerohanian Mewakili Institusi">Mengikuti
                                        Kegiatan di Bidang Sosial/Kerohanian yang mewakili institusi di luar
                                        Perguruan Tinggi</option>
                                    <option value="Lomba Mewakili Insititusi">Mengikuti Lomba mewakili institusi di
                                        luar Perguruan Tinggi</option>
                                    <option value="Pelatihan Keterampilan Di Luar PT">Pelatihan Keterampilan Di
                                        luar PT</option>
                                    <option value="Pengakuan Dari Institusi Lain">Pengakuan Dari Institusi Lain
                                    </option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tingkat
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="tingkat" id="tingkat-prestasi" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                    {{-- Kompetisi --}}
                                    <option value="Tidak Ada" class="italic">Pilih Tingkatan</option>
                                    <option value="Internasional">Internasional</option>
                                    <option value="Nasional">Nasional</option>
                                    <option value="Regional">Regional</option>
                                    <option value="Perguruan Tinggi">Perguruan Tinggi</option>
                                    {{-- Publikasi --}}
                                    <option value="Nasional Terakreditasi">Nasional Terakreditasi</option>
                                    <option value="Regional Tidak Terakreditasi">Regional Tidak Terakreditasi
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Raihan
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="raihan" id="raihan-prestasi" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                    <option value="Tidak Ada" class="italic">Pilih Juara</option>
                                    <option value="Juara 1">Juara 1</option>
                                    <option value="Juara 2">Juara 2</option>
                                    <option value="Juara 3">Juara 3</option>
                                    <option value="Juara Harapan">Juara Harapan</option>
                                    {{-- Forum Ilmiah, Kegiatan Sosial / Kerohanian, --}}
                                    <option value="Pembicara">Pembicara</option>
                                    <option value="Moderator">Moderator</option>
                                    <option value="Peserta">Peserta</option>
                                    {{-- Karya Populer/Karya Ilmiah --}}
                                    <option value="Ketua">Ketua</option>
                                    <option value="Anggota">Anggota</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tempat
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tempat" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Mulai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-mulai" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Selesai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-selesai" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Bukti <span class="italic">(pdf, jpg,
                                        jpeg, atau png)</span>
                                    maks 5MB<span class="text-red-500">*</span></label>
                                </label>
                                {{-- Prod: required --}}
                                <input type="file" name="bukti" id="bukti" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openAchievement = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>

                    {{-- Modal Edit --}}
                    <x-modal title="Edit Data Prestasi" show="openEditAchievement">
                        <form method="POST" enctype="multipart/form-data"
                            x-bind:action="'{{ route('laporan.achievements.update', ':id') }}'.replace(':id', editDataAchievement
                                .id)"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Prestasi
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama-prestasi"
                                    x-model="editDataAchievement['achievements-name']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tipe Prestasi
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="tipe-prestasi" id="tipe-prestasi"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                    x-model="editDataAchievement['tipe-prestasi']">
                                    <option value="" class="italic">Pilih Tipe</option>
                                    <option value="Kompetisi Pemerintahan Individu">Kompetisi Pemerintahan Individu
                                    </option>
                                    <option value="Kompetisi Pemerintahan Kelompok">Kompetisi Pemerintahan Kelompok
                                    </option>
                                    <option value="Kompetisi Non-Pemerintahan Individu">Kompetisi Non-Pemerintahan
                                        Individu</option>
                                    <option value="Kompetisi Non-Pemerintahan Kelompok">Kompetisi Non-Pemerintahan
                                        Kelompok</option>
                                    <option value="Juri/Wasit/Pelatih">Menjadi Juri/Wasit/Pelatih</option>
                                    <option value="Anggota Dalam Penelitian/Pengabdian">Anggota Dalam
                                        Penelitian/Pengabdian</option>
                                    <option value="Kegiatan/Forum Ilmiah">Mengikuti Kegiatan/Forum Ilmiah</option>
                                    <option value="Karya Yang Didanai">Menghasilkan Karya Yang Didanai</option>
                                    <option value="Karya Populer Yang Diterbitkan">Menghasilkan Karya Populer Yang
                                        Diterbitkan</option>
                                    <option value="Penulis Buku ISBN">Penulis Buku ISBN</option>
                                    <option value="Paten/Paten Sederhana">Paten/Paten Sederhana</option>
                                    <option value="Publikasi Jurnal Internasional/Nasional">Publikasi Jurnal
                                        Internasional/Nasional Bereputasi</option>
                                    <option value="Ikut Kegiatan Sosial/Kerohanian Mewakili Institusi">Mengikuti
                                        Kegiatan di Bidang Sosial/Kerohanian yang mewakili institusi di luar
                                        Perguruan Tinggi</option>
                                    <option value="Lomba Mewakili Insititusi">Mengikuti Lomba mewakili institusi di
                                        luar Perguruan Tinggi</option>
                                    <option value="Pelatihan Keterampilan Di Luar PT">Pelatihan Keterampilan Di
                                        luar PT</option>
                                    <option value="Pengakuan Dari Institusi Lain">Pengakuan Dari Institusi Lain
                                    </option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tingkat
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="tingkat" id="tingkat-prestasi"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                    x-model="editDataAchievement['level']">
                                    {{-- Kompetisi --}}
                                    <option value="Tidak Ada" class="italic">Pilih Tingkatan</option>
                                    <option value="Internasional">Internasional</option>
                                    <option value="Nasional">Nasional</option>
                                    <option value="Regional">Regional</option>
                                    <option value="Perguruan Tinggi">Perguruan Tinggi</option>
                                    {{-- Publikasi --}}
                                    <option value="Nasional Terakreditasi">Nasional Terakreditasi</option>
                                    <option value="Regional Tidak Terakreditasi">Regional Tidak Terakreditasi
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Raihan
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="raihan"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                    x-model="editDataAchievement['award']">
                                    <option value="Tidak Ada" class="italic">Pilih Juara</option>
                                    <option value="Juara 1">Juara 1</option>
                                    <option value="Juara 2">Juara 2</option>
                                    <option value="Juara 3">Juara 3</option>
                                    <option value="Juara Harapan">Juara Harapan</option>
                                    {{-- Forum Ilmiah, Kegiatan Sosial / Kerohanian, --}}
                                    <option value="Pembicara">Pembicara</option>
                                    <option value="Moderator">Moderator</option>
                                    <option value="Peserta">Peserta</option>
                                    {{-- Karya Populer/Karya Ilmiah --}}
                                    <option value="Ketua">Ketua</option>
                                    <option value="Anggota">Anggota</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tempat
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tempat" x-model="editDataAchievement['place']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Mulai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-mulai" x-model="editDataAchievement['start-date']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Selesai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-selesai" x-model="editDataAchievement['end-date']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Bukti <span class="italic">(pdf, jpg,
                                        jpeg, atau png)</span>
                                    maks 5MB<span class="text-red-500">*</span></label>
                                </label>
                                <input type="file" name="bukti" id="bukti" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openEditAchievement = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const tipePrestasi = document.getElementById("tipe-prestasi");
                            const tingkatPrestasi = document.getElementById("tingkat-prestasi");
                            const raihanPrestasi = document.getElementById("raihan-prestasi");

                            const dataPrestasi = {
                                "Kompetisi Pemerintahan Individu": ["Internasional", "Nasional", "Regional",
                                    "Perguruan Tinggi"
                                ],
                                "Kompetisi Pemerintahan Kelompok": ["Internasional", "Nasional", "Regional",
                                    "Perguruan Tinggi"
                                ],
                                "Kompetisi Non-Pemerintahan Individu": ["Internasional", "Nasional", "Regional",
                                    "Perguruan Tinggi"
                                ],
                                "Kompetisi Non-Pemerintahan Kelompok": ["Internasional", "Nasional", "Regional",
                                    "Perguruan Tinggi"
                                ],
                                "Juri/Wasit/Pelatih": ["Internasional", "Nasional", "Regional",
                                    "Perguruan Tinggi"
                                ],
                                "Anggota Dalam Penelitian/Pengabdian": ["Regional", "Perguruan Tinggi"],
                                "Kegiatan/Forum Ilmiah": ["Internasional", "Nasional", "Regional", "Perguruan Tinggi"],
                                "Karya Yang Didanai": ["Internasional", "Nasional", "Regional", "Perguruan Tinggi"],
                                "Karya Populer Yang Diterbitkan": ["Internasional", "Nasional", "Regional", "Perguruan Tinggi"],
                                "Penulis Buku ISBN": ["Nasional"],
                                "Paten/Paten Sederhana": ["Nasional"],
                                "Publikasi Jurnal Internasional/Nasional": ["Internasional", "Nasional Terakreditasi",
                                    "Regional Tidak Terakreditasi"
                                ],
                                "Ikut Kegiatan Sosial/Kerohanian Mewakili Institusi": ["Internasional", "Nasional", "Regional"],
                                "Lomba Mewakili Insititusi": ["Internasional", "Nasional", "Regional"],
                                "Pelatihan Keterampilan Di Luar PT": ["Perguruan Tinggi"],
                                "Pengakuan Dari Institusi Lain": ["Internasional", "Nasional", "Regional"]
                            };

                            const raihanData = {
                                "kompetisi": ["Juara 1", "Juara 2", "Juara 3", "Juara Harapan"],
                                "juri/wasit/pelatih": ["Juri", "Wasit", "Pelatih"],
                                "forum": ["Pembicara", "Moderator", "Peserta"],
                                "karya": ["Ketua", "Anggota"],
                            };

                            tipePrestasi.addEventListener("change", function() {
                                const value = this.value;
                                tingkatPrestasi.innerHTML = '<option value="">Pilih Tingkatan</option>';

                                if (dataPrestasi[value]) {
                                    dataPrestasi[value].forEach(level => {
                                        const opt = document.createElement("option");
                                        opt.value = level;
                                        opt.textContent = level;
                                        tingkatPrestasi.appendChild(opt);
                                    });
                                }

                                // isi raihan prestasi
                                raihanPrestasi.innerHTML = '<option value="">Pilih Raihan</option>';
                                let listRaihan = [];

                                if ([
                                        "Kompetisi Pemerintahan Individu",
                                        "Kompetisi Pemerintahan Kelompok",
                                        "Kompetisi Non-Pemerintahan Individu",
                                        "Kompetisi Non-Pemerintahan Kelompok",
                                        "Lomba Mewakili Institusi"
                                    ].includes(value)) {
                                    listRaihan = raihanData["kompetisi"];
                                } else if ([
                                        "Kegiatan/Forum Ilmiah",
                                        "Kegiatan Sosial / Kerohanian"
                                    ].includes(value)) {
                                    listRaihan = raihanData["forum"];
                                } else if ([
                                        "Karya Yang Didanai",
                                        "Karya Populer Yang Diterbitkan",
                                        "Publikasi Jurnal Internasional/Nasional"
                                    ].includes(value)) {
                                    listRaihan = raihanData["karya"];
                                } else if ([
                                        "Juri/Wasit/Pelatih"
                                    ].includes(value)) {
                                    listRaihan = raihanData['juri/wasit/pelatih']
                                } else {
                                    listRaihan = ["Peserta"];
                                }

                                listRaihan.forEach(r => {
                                    const opt = document.createElement("option");
                                    opt.value = r;
                                    opt.textContent = r;
                                    raihanPrestasi.appendChild(opt);
                                });
                            });
                        });
                    </script>
                @endif
                {{-- Divider --}}
                <hr class="my-6 border-gray-100">

                {{-- Independent Activities --}}
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800">4. Kegiatan Mandiri</h4>
                    @if ($laporan->status === 'Draft')
                        <button @click="openIndependent = true"
                            class="bg-[#f9d223] px-3 py-1.5 rounded-lg hover:bg-[#ffe056] transition cursor-pointer shadow-sm text-sm font-semibold text-gray-800 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah
                        </button>
                    @endif
                </div>

                <div class="overflow-x-auto w-full">
                    <x-tabel :headers="[
                        'No',
                        'Nama Kegiatan',
                        'Tipe Kegiatan',
                        'Keikutsertaan',
                        'Tempat',
                        'Tanggal Mulai',
                        'Tanggal Selesai',
                        'Bukti',
                        'Status',
                    ]" :columns="[
                        'activity-name',
                        'activity-type',
                        'participation',
                        'place',
                        'start-date',
                        'end-date',
                        'bukti',
                        'status',
                    ]" :rows="$parsingIndependentActivities" idKey="id"
                        editEvent="edit-independent" deleteRoute="laporan.independent-activities.hapus" :status="$laporan->status"
                        style="draft" />
                </div>

                @if ($laporan->status === 'Draft')
                    {{-- Modal Tambah --}}
                    <x-modal title="Tambah Data Kegiatan Mandiri" show="openIndependent">
                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('laporan.independent-activities.store', $laporan->laporan_id) }}"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Kegiatan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama-kegiatan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tipe Kegiatan
                                    <span class="text-red-500">*</span>
                                </label>
                                <select type="text" name="tipe-kegiatan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                    <option value="" class="italic">Pilih Tipe</option>
                                    <option value="Magang Bersertifikat">Magang Bersertifikat</option>
                                    <option value="Studi Independent">Studi Independent</option>
                                    <option value="Kampus Mengajar">Kampus Mengajar</option>
                                    <option value="IISMA">IISMA</option>
                                    <option value="Pertukaran Mahasiswa Merdeka">Pertukaran Mahasiswa Merdeka
                                    </option>
                                    <option value="KKN Tematik">KKN Tematik</option>
                                    <option value="Proyek Kemanusiaan">Proyek Kemanusiaan</option>
                                    <option value="Riset Atau Penelitian">Riset Atau Penelitian</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Keikutsertaan
                                    <span class="text-red-500">*</span>
                                </label>
                                <select type="text" name="keikutsertaan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                    <option value="" class="italic">Pilih Keikutsertaan</option>
                                    <option value="Peserta">Peserta</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tempat
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tempat" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Mulai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-mulai" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Selesai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-selesai" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Bukti <span class="italic">(pdf, jpg,
                                        jpeg, atau png)</span>
                                    maks 5MB<span class="text-red-500">*</span></label>
                                </label>
                                {{-- Prod: required --}}
                                <input type="file" name="bukti" id="bukti" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openIndependent = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>
                    {{-- Modal Edit --}}
                    <x-modal title="Edit Data Kegiatan Mandiri" show="openEditIndependent">
                        <form method="POST" enctype="multipart/form-data"
                            x-bind:action="'{{ route('laporan.independent-activities.update', ':id') }}'.replace(':id',
                                editDataIndependent.id)"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Kegiatan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama-kegiatan"
                                    x-model="editDataIndependent['activity-name']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tipe Kegiatan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tipe-kegiatan"
                                    x-model="editDataIndependent['activity-type']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Keikutsertaan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="keikutsertaan"
                                    x-model="editDataIndependent['participation']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tempat
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tempat" x-model="editDataIndependent['place']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Mulai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-mulai" x-model="editDataIndependent['start-date']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tanggal Selesai
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal-selesai" x-model="editDataIndependent['end-date']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Bukti <span class="italic">(pdf, jpg,
                                        jpeg, atau png)</span>
                                    maks 5MB<span class="text-red-500">*</span></label>
                                </label>
                                <input type="file" name="bukti" id="bukti" accept=".jpg,.jpeg,.png,.pdf"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openEditIndependent = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>
                @endif
            </div>

            {{-- Evaluations --}}
            <div x-cloak x-data="{ openEvaluation: false, openEditEvaluation: false, editDataEvaluation: {} }"
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">C. Evaluasi</h3>

                    @if ($parsingEvaluations && $laporan->status === 'Draft')
                        <div class="flex gap-2">
                            <button x-data='{ eval: @json($parsingEvaluations) }'
                                @click="
                                            openEditEvaluation = true;
                                            editDataEvaluation = eval;
                                        "
                                class="px-3 py-1.5 text-white bg-[#2179ca] hover:bg-[#1c6bb4] rounded-md shadow-sm text-sm font-semibold flex items-center gap-1 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Edit
                            </button>
                            {{-- Hapus (keeping logic) --}}
                            <button x-data='{ eval: @json($parsingEvaluations) }'
                                @click="$dispatch('delete-row', { id: eval.id, route: '{{ route('laporan.evaluations.hapus', ':id') }}'.replace(':id', eval.id) })"
                                class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-md shadow-sm text-sm font-semibold flex items-center gap-1 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 000-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Hapus
                            </button>
                        </div>
                    @elseif (!$parsingEvaluations || $laporan->status === 'Draft')
                        <button @click="openEvaluation = true"
                            class="bg-[#f9d223] px-3 py-1.5 rounded-lg hover:bg-[#ffe056] transition cursor-pointer shadow-sm text-sm font-semibold text-gray-800 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah
                        </button>
                    @endif
                </div>

                {{-- Data yg ditampilkan --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-gray-600 font-semibold mb-2">Faktor Pendukung <span class="text-red-500">*</span></p>
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 min-h-[150px]">
                            {{ $parsingEvaluations->support_factors ?? '-' }}
                        </div>
                    </div>
                    <div>
                        <p class="text-gray-600 font-semibold mb-2">Faktor Penghambat <span class="text-red-500">*</span></p>
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 min-h-[150px]">
                            {{ $parsingEvaluations->barrier_factors ?? '-' }}
                        </div>
                    </div>
                </div>

                @if ($parsingEvaluations && $laporan->status === 'Draft')
                    {{-- Buttons moved to header --}}
                @elseif (!$parsingEvaluations || $laporan->status === 'Draft')
                    {{-- Buttons moved to header --}}
                @endif

                {{-- Modal Tambah --}}
                <x-modal title="Tambah Data Evaluasi" show="openEvaluation">
                    <form method="POST" action="{{ route('laporan.evaluations.store', $laporan->laporan_id) }}"
                        x-data="{ submitting: false }" x-on:submit="submitting = true">
                        @csrf
                        <div class="mb-3">
                            <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Faktor Pendukung</p>
                            <textarea name="faktor-pendukung" id="faktor-pendukung"
                                class="resize-none px-2 py-0.5 w-full h-[200px] cursor-pointer shadow-md border border-[#c0c0c0] focus:outline-none focus:ring-0"
                                placeholder="Tuliskan faktor pendukungmu disini..."></textarea>
                        </div>
                        <div class="mb-3">
                            <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Faktor Penghambat</p>
                            <textarea name="faktor-penghambat" id="faktor-penghambat"
                                class="resize-none px-2 py-0.5 w-full h-[200px] cursor-pointer shadow-md border border-[#c0c0c0] focus:outline-none focus:ring-0"
                                placeholder="Tuliskan faktor penghambatmu disini..."></textarea>
                        </div>

                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" @click="openEvaluation = false"
                                class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                            <button type="submit" x-bind:disabled="submitting"
                                x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                :class="submitting
                                    ?
                                    'cursor-not-allowed bg-gray-400' :
                                    'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                class="px-3 py-1 transition text-white rounded"></button>
                        </div>
                    </form>
                </x-modal>

                {{-- Modal Edit --}}
                <x-modal title="Edit Data Evaluasi" show="openEditEvaluation">
                    <form method="POST"
                        x-bind:action="'{{ route('laporan.evaluations.update', ':id') }}'.replace(':id', editDataEvaluation.id)"
                        x-data="{ submitting: false }" x-on:submit="submitting = true">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Faktor Pendukung</p>
                            <textarea name="faktor-pendukung" id="faktor-pendukung"
                                class="resize-none px-2 py-0.5 w-full h-[200px] cursor-pointer shadow-md border border-[#c0c0c0] focus:outline-none focus:ring-0"
                                placeholder="Tuliskan faktor pendukungmu disini..." x-model="editDataEvaluation.support_factors"></textarea>
                        </div>
                        <div class="mb-3">
                            <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Faktor Penghambat</p>
                            <textarea name="faktor-penghambat" id="faktor-penghambat"
                                class="resize-none px-2 py-0.5 w-full h-[200px] cursor-pointer shadow-md border border-[#c0c0c0] focus:outline-none focus:ring-0"
                                placeholder="Tuliskan faktor penghambatmu disini..." x-model="editDataEvaluation.barrier_factors"></textarea>
                        </div>

                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" @click="openEditEvaluation = false"
                                class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                            <button type="submit" x-bind:disabled="submitting"
                                x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                :class="submitting
                                    ?
                                    'cursor-not-allowed bg-gray-400' :
                                    'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                class="px-3 py-1 transition text-white rounded"></button>
                        </div>
                    </form>
                </x-modal>
            </div>

            {{-- Target Next SMT --}}
            {{-- Next Semester Plan Unified Card --}}
            <div x-cloak x-data="{
                openTargetRep: false, openEditTargetRep: false, editDataTargetRep: {},
                openTargetAcademic: false, openEditTargetAcademic: false, editDataTargetAcademic: {},
                openTargetAchievement: false, openEditTargetAchievement: false, editDatatargetAchievement: {},
                openTargetIndependent: false, openEditTargetIndependent: false, editDataTargetIndependent: {}
            }"
                x-on:edit-target-rep.window="editDataTargetRep = $event.detail; openEditTargetRep = true"
                x-on:edit-target-academic.window="editDataTargetAcademic = $event.detail; openEditTargetAcademic = true"
                x-on:edit-target-achievement.window="editDatatargetAchievement = $event.detail; openEditTargetAchievement = true"
                x-on:edit-target-independent.window="editDataTargetIndependent = $event.detail; openEditTargetIndependent = true"
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

                <div class="mb-6 pb-2 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">D. Rencana Semester Depan</h3>
                </div>

                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800">1. Rencana IPS & IPK</h4>
                    @if ($laporan->status === 'Draft')
                        <button @click="openTargetRep = true"
                            class="bg-[#f9d223] px-3 py-1.5 rounded-lg hover:bg-[#ffe056] transition cursor-pointer shadow-sm text-sm font-semibold text-gray-800 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah
                        </button>
                    @endif
                </div>

                <div class="overflow-x-auto w-full">
                    <x-tabel :headers="['No', 'Semester', 'Target IPS', 'Target IPK', 'Status']" :columns="['semester', 'target-ips', 'target-ipk', 'status']" :rows="$parsingNextReports" idKey="id"
                        editEvent="edit-target-rep" deleteRoute="laporan.next-semester-reports.hapus" :status="$laporan->status"
                        style="draft" />
                </div>

                @if ($laporan->status === 'Draft')
                    {{-- Modal Tambah --}}
                    <x-modal title="Tambah Data Target IPS dan IPK" show="openTargetRep">
                        <form method="POST"
                            action="{{ route('laporan.next-semester-reports.store', $laporan->laporan_id) }}"
                            enctype="multipart/form-data" x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Semester <span
                                        class="text-red-500">*</span></label>
                                <select name="semester" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Target IPS <span
                                        class="text-red-500">*</span></label>
                                <span class="text-[2pt] text-red-500 italic">Maks 4.00</span>
                                <input type="number" name="target-ips" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                    step="0.01" min="0" max="4">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Target IPK <span
                                        class="text-red-500">*</span></label>
                                <span class="text-[2pt] text-red-500 italic">Maks 4.00</span>
                                <input type="number" name="target-ipk" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                    step="0.01" min="0" max="4">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openTargetRep = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>
                    {{-- Modal Edit --}}
                    <x-modal title="Edit Data Rencana IPS dan IPK" show="openEditTargetRep">
                        <form
                            x-bind:action="'{{ route('laporan.next-semester-reports.update', ':id') }}'.replace(':id',
                                editDataTargetRep.id)"
                            method="POST" x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Semester <span
                                        class="text-red-500">*</span></label>
                                <select name="semester" x-model="editDataTargetRep['semester']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                    <template x-for="n in 8" :key="n">
                                        <option x-bind:value="n" x-text="n"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Target IPS <span
                                        class="text-red-500">*</span></label>
                                <span class="text-[2pt] text-red-500 italic">Maks 4.00</span>
                                <input type="number" name="target-ips" x-model="editDataTargetRep['target-ips']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                    step="0.01" min="0" max="4">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Target IPK <span
                                        class="text-red-500">*</span></label>
                                <span class="text-[2pt] text-red-500 italic">Maks 4.00</span>
                                <input type="number" name="target-ipk" x-model="editDataTargetRep['target-ipk']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                    step="0.01" min="0" max="4">
                            </div>
                            {{-- btn --}}
                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openEditTargetRep = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">
                                    Batal
                                </button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded">
                                </button>
                            </div>
                        </form>
                    </x-modal>
                @endif
                {{-- Divider --}}
                <hr class="my-6 border-gray-100">

                {{-- Target Keg Akademik --}}
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800">2. Rencana Kegiatan Akademik</h4>
                    @if ($laporan->status === 'Draft')
                        <button @click="openTargetAcademic = true"
                            class="bg-[#f9d223] px-3 py-1.5 rounded-lg hover:bg-[#ffe056] transition cursor-pointer shadow-sm text-sm font-semibold text-gray-800 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah
                        </button>
                    @endif
                </div>

                <div class="overflow-x-auto w-full">
                    <x-tabel :headers="['No', 'Nama Kegiatan', 'Rencana/Strategi', 'Status']" :columns="['activity-name', 'strategy', 'status']" :rows="$parsingNextAcademicActivities" idKey="id"
                        editEvent="edit-target-academic" deleteRoute="laporan.next-smt-activities.hapus"
                        :status="$laporan->status" style="draft" />
                </div>
                    {{-- Modal tambah --}}
                    <x-modal title="Tambah Data Rencana Kegiatan Akademik" show="openTargetAcademic">
                        <form method="POST"
                            action="{{ route('laporan.next-smt-activities.store', $laporan->laporan_id) }}"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Kegiatan</label>
                                <input type="text" name="nama-kegiatan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Rencana/Strategi</label>
                                <input type="text" name="rencana-strategi" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Keikutsertaan</label>
                                <input type="text" name="keikutsertaan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openTargetAcademic = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>
                    {{-- Modal Edit --}}
                    <x-modal title="Edit Data Rencana Kegiatan Akademik" show="openEditTargetAcademic">
                        <form method="POST"
                            x-bind:action="'{{ route('laporan.next-smt-activities.update', ':id') }}'.replace(':id',
                                editDataTargetAcademic.id)"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Kegiatan</label>
                                <input type="text" name="nama-kegiatan"
                                    x-model="editDataTargetAcademic['activity-name']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Rencana/Strategi</label>
                                <input type="text" name="rencana-strategi"
                                    x-model="editDataTargetAcademic['strategy']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openEditTargetAcademic = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>

                {{-- Divider --}}
                <hr class="my-6 border-gray-100">

                {{-- Target Achievements --}}
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800">3. Rencana Prestasi</h4>
                    @if ($laporan->status === 'Draft')
                        <button @click="openTargetAchievement = true"
                            class="bg-[#f9d223] px-3 py-1.5 rounded-lg hover:bg-[#ffe056] transition cursor-pointer shadow-sm text-sm font-semibold text-gray-800 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah
                        </button>
                    @endif
                </div>

                <div class="overflow-x-auto w-full">
                    <x-tabel :headers="['No', 'Nama Prestasi', 'Tingkat', 'Raihan', 'Status']" :columns="['achievements-name', 'level', 'award', 'status']" :rows="$parsingNextAchievements" idKey="id"
                        editEvent="edit-target-achievement" deleteRoute="laporan.next-smt-achievements.hapus"
                        :status="$laporan->status" style="draft" />
                </div>
                    {{-- Modal Tambah --}}
                    <x-modal title="Tambah Data Rencana Prestasi" show="openTargetAchievement">
                        <form method="POST"
                            action="{{ route('laporan.next-smt-achievements.store', $laporan->laporan_id) }}"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Prestasi
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama-prestasi" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tingkat
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tingkat" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Raihan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="raihan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openTargetAchievement = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>
                    {{-- Modal Edit --}}
                    <x-modal title="Edit Data Rencana Prestasi" show="openEditTargetAchievement">
                        <form method="POST"
                            x-bind:action="'{{ route('laporan.next-smt-achievements.update', ':id') }}'.replace(':id',
                                editDatatargetAchievement.id)"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Prestasi
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama-prestasi"
                                    x-model="editDatatargetAchievement['achievements-name']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tingkat
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tingkat" x-model="editDatatargetAchievement['level']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Raihan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="raihan" x-model="editDatatargetAchievement['award']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openEditTargetAchievement = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>

                {{-- Divider --}}
                <hr class="my-6 border-gray-100">

                {{-- Target Independent --}}
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                    <h4 class="text-lg font-bold text-gray-800">4. Rencana Kegiatan Mandiri</h4>
                    @if ($laporan->status === 'Draft')
                        <button @click="openTargetIndependent = true"
                            class="bg-[#f9d223] px-3 py-1.5 rounded-lg hover:bg-[#ffe056] transition cursor-pointer shadow-sm text-sm font-semibold text-gray-800 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah
                        </button>
                    @endif
                </div>

                <div class="overflow-x-auto w-full">
                    <x-tabel :headers="['No', 'Nama Kegiatan', 'Rencana/Strategi', 'Keikutsertaan', 'Status']" :columns="['activity-name', 'strategy', 'participation', 'status']" :rows="$parsingNextIndependentActivities" idKey="id"
                        editEvent="edit-target-independent" deleteRoute="laporan.next-smt-independent.hapus"
                        :status="$laporan->status" style="draft" />
                </div>
                    {{-- Modal tambah --}}
                    <x-modal title="Tambah Data Rencana Kegiatan Mandiri" show="openTargetIndependent">
                        <form method="POST"
                            action="{{ route('laporan.next-smt-independent.store', $laporan->laporan_id) }}"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Kegiatan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama-kegiatan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Rencana/Strategi
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="rencana-strategi" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Keikutsertaan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="keikutsertaan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openTargetIndependent = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>
                    {{-- Modal Edit --}}
                    <x-modal title="Tambah Data Rencana Kegiatan Mandiri" show="openEditTargetIndependent">
                        <form method="POST"
                            x-bind:action="'{{ route('laporan.next-smt-independent.update', ':id') }}'.replace(':id',
                                editDataTargetIndependent.id)"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Kegiatan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama-kegiatan"
                                    x-model="editDataTargetIndependent['activity-name']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Rencana/Strategi
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="rencana-strategi"
                                    x-model="editDataTargetIndependent['strategy']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Keikutsertaan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="keikutsertaan"
                                    x-model="editDataTargetIndependent['participation']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openEditTargetIndependent = false"
                                    class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>

            </div>

            {{-- Keuangan --}}
            <div x-cloak x-data="{ openKeuangan: false, openEditKeuangan: false, editDataKeuangan: {} }"
                x-on:edit-keuangan="editDataKeuangan = $event.detail; openEditKeuangan = true"
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">E. Laporan Keuangan</h3>
                    @if ($laporan->status === 'Draft')
                        <button @click="openKeuangan = true"
                            class="bg-[#f9d223] px-3 py-1.5 rounded-lg hover:bg-[#ffe056] transition cursor-pointer shadow-sm text-sm font-semibold text-gray-800 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah
                        </button>
                    @endif
                </div>

                {{-- Ringkasan Total Keuangan --}}
                <div class="mb-3">
                    <div
                        class="flex items-center justify-between bg-white border-l-4 border-[#f9d223] rounded-lg shadow-sm px-4 py-3">
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
                        style="draft" />
                </div>

                @if ($laporan->status === 'Draft')
                    {{-- Modal tambah --}}
                    <x-modal title="Tambah Data Keuangan Mahasiswa" show="openKeuangan">
                        <form method="POST" action="{{ route('laporan.keuangan.store', $laporan->laporan_id) }}"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Keperluan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="keperluan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nominal
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="numeric" name="nominal" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openKeuangan = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>
                    {{-- Modal Edit --}}
                    <x-modal title="Tambah Data Keuangan Mahasiswa" show="openEditKeuangan">
                        <form method="POST"
                            x-bind:action="'{{ route('laporan.keuangan.update', ':id') }}'.replace(':id',
                                editDataKeuangan.id)"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Keperluan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="keperluan" x-model="editDataKeuangan['keperluan']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nominal
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="numeric" name="nominal" x-model="editDataKeuangan['nominal']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openEditKeuangan = false"
                                    class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>
                @endif
            </div>

            {{-- Kesan Pesan --}}
            <div x-cloak x-data="{ openKesanPesan: false, openEditKesanPesan: false, editDataKesanPesan: {} }"
                x-on:edit-pesan-kesan="editDataKesanPesan = $event.detail; openEditKesanPesan = true"
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">F. Kesan dan Pesan Mahasiswa</h3>
                    @if ($laporan->status === 'Draft')
                        @if (!$parsingKesanPesan || count($parsingKesanPesan) === 0)
                             <button @click="openKesanPesan = true"
                                class="bg-[#f9d223] px-3 py-1.5 rounded-lg hover:bg-[#ffe056] transition cursor-pointer shadow-sm text-sm font-semibold text-gray-800 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Tambah
                            </button>
                        @endif
                    @endif
                </div>

                <div class="overflow-x-auto w-full">
                    <x-tabel :headers="['No', 'Kesan', 'Pesan', 'Status']" :columns="['kesan', 'pesan', 'status']" :rows="$parsingKesanPesan" idKey="id"
                        editEvent="edit-pesan-kesan" deleteRoute="laporan.kesan-pesan.hapus" :status="$laporan->status"
                        style="draft" />
                </div>

                @if ($laporan->status === 'Draft')
                    @if (!$parsingKesanPesan || count($parsingKesanPesan) === 0)
                    @endif

                    {{-- Modal tambah --}}
                    <x-modal title="Tambah Data Keuangan Mahasiswa" show="openKesanPesan">
                        <form method="POST" action="{{ route('laporan.kesan-pesan.store', $laporan->laporan_id) }}"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Kesan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="kesan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Pesan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="numeric" name="pesan" required
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openKesanPesan = false"
                                    class="px-3 py-1 bg-[#f13636] text-[#fefefe] hover:bg-[#d72626] rounded transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>
                    {{-- Modal Edit --}}
                    <x-modal title="Tambah Data Keuangan Mahasiswa" show="openEditKesanPesan">
                        <form method="POST"
                            x-bind:action="'{{ route('laporan.kesan-pesan.update', ':id') }}'.replace(':id',
                                editDataKesanPesan.id)"
                            x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Kesan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="kesan" x-model="editDataKesanPesan['kesan']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nominal
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="pesan" x-model="editDataKesanPesan['pesan']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openEditKesanPesan = false"
                                    class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                <button type="submit" x-bind:disabled="submitting"
                                    x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                    :class="submitting
                                        ?
                                        'cursor-not-allowed bg-gray-400' :
                                        'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                    class="px-3 py-1 transition text-white rounded"></button>
                            </div>
                        </form>
                    </x-modal>
                @endif
            </div>

            {{-- Delete Modal --}}
            <x-modal-delete />

            {{-- Button Aksi --}}
            <div x-cloak x-data="{ openModalKonfirmasi: false }" class="mt-8 flex justify-end gap-3 border-t border-gray-200 pt-6">
                <a href="{{ route('mahasiswa.dashboard') }}"
                    class="px-4 py-2 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition shadow-sm">
                    Kembali
                </a>
                <button @click="openModalKonfirmasi = true"
                    class="px-4 py-2 bg-[#09697E] hover:bg-[#075363] text-white font-medium rounded-lg shadow-sm transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Ajukan Laporan
                </button>
                {{-- Modal Konfirmasi --}}
                <x-modal title="Konfirmasi Pengajuan Laporan" show="openModalKonfirmasi">
                    <h1 class="text-center font-semibold">Apakah Anda yakin ingin mengirim laporan?</h1>
                    {{-- icon --}}
                    <div class="flex items-center justify-center">
                        <svg viewBox="0 0 24 24" fill="none" class="w-[100px] h-[100px]"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M21.7605 15.92L15.3605 4.4C14.5005 2.85 13.3105 2 12.0005 2C10.6905 2 9.50047 2.85 8.64047 4.4L2.24047 15.92C1.43047 17.39 1.34047 18.8 1.99047 19.91C2.64047 21.02 3.92047 21.63 5.60047 21.63H18.4005C20.0805 21.63 21.3605 21.02 22.0105 19.91C22.6605 18.8 22.5705 17.38 21.7605 15.92ZM11.2505 9C11.2505 8.59 11.5905 8.25 12.0005 8.25C12.4105 8.25 12.7505 8.59 12.7505 9V14C12.7505 14.41 12.4105 14.75 12.0005 14.75C11.5905 14.75 11.2505 14.41 11.2505 14V9ZM12.7105 17.71C12.6605 17.75 12.6105 17.79 12.5605 17.83C12.5005 17.87 12.4405 17.9 12.3805 17.92C12.3205 17.95 12.2605 17.97 12.1905 17.98C12.1305 17.99 12.0605 18 12.0005 18C11.9405 18 11.8705 17.99 11.8005 17.98C11.7405 17.97 11.6805 17.95 11.6205 17.92C11.5605 17.9 11.5005 17.87 11.4405 17.83C11.3905 17.79 11.3405 17.75 11.2905 17.71C11.1105 17.52 11.0005 17.26 11.0005 17C11.0005 16.74 11.1105 16.48 11.2905 16.29C11.3405 16.25 11.3905 16.21 11.4405 16.17C11.5005 16.13 11.5605 16.1 11.6205 16.08C11.6805 16.05 11.7405 16.03 11.8005 16.02C11.9305 15.99 12.0705 15.99 12.1905 16.02C12.2605 16.03 12.3205 16.05 12.3805 16.08C12.4405 16.1 12.5005 16.13 12.5605 16.17C12.6105 16.21 12.6605 16.25 12.7105 16.29C12.8905 16.48 13.0005 16.74 13.0005 17C13.0005 17.26 12.8905 17.52 12.7105 17.71Z"
                                    fill="#f71d1d"></path>
                            </g>
                        </svg>
                    </div>
                    <p class="font-bold italic text-md text-center"><span
                            class="text-red-500 font-bold text-md">*</span>Pastikan semua data beserta bukti kegiatan
                        sudah benar!</p>
                    {{-- Button --}}
                    <div class="flex items-center justify-center gap-5">
                        {{-- Batal --}}
                        <button type="button" @click="openModalKonfirmasi = false"
                            class="px-3 py-1 bg-[#f13636] text-[#fefefe] rounded hover:bg-[#d72626] transition cursor-pointer">
                            Batal
                        </button>
                        {{-- Konfirmasi --}}
                        <form action="{{ route('laporan.ajukan', $laporan->laporan_id) }}" method="POST"
                            enctype="multipart/form-data" x-data="{ submitting: false }" x-on:submit="submitting = true">
                            @csrf
                            @method('PUT')
                            <button type="submit" x-bind:disabled="submitting"
                                x-text="submitting ? 'Mengirim...' : 'Simpan'"
                                :class="submitting
                                    ?
                                    'cursor-not-allowed bg-gray-400' :
                                    'cursor-pointer bg-[#21C40F] hover:bg-[#0DD603]'"
                                class="px-3 py-1 text-[#fefefe] rounded transition">
                                Konfirmasi
                            </button>
                        </form>
                    </div>
                </x-modal>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('bukti').addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            const allowedTypes = [
                'image/jpeg',
                'image/jpg',
                'image/png',
                'application/pdf'
            ];

            const maxSize = 5 * 1024 * 1024;

            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'File tidak valid',
                    text: 'Format file harus jpg, jpeg, png, png, atau pdf',
                });
                this.value = '';
                return;
            }

            if (file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran file terlalu besar',
                    text: 'Ukuran maksimal file adalah 5MB',
                    confirmButtonColor: '#09697E', // hijau
                });
                this.value = '';
            }
        });
    </script>
@endpush

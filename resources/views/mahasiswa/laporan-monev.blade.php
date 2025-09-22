<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <title>Isi Monev</title>
</head>

<body class="bg-[#F8F6F6]">
    <x-navbar-mhs mhsAvatar='{{ $dataMahasiswa->avatar }}' />

    <section class="flex justify-center w-full h-auto">
        <div class="bg-[#fdfdfd] w-[1100px] h-auto p-6">
            <h2 class="text-xl font-bold mb-2">Laporan Monev</h2>
            <div class="w-full h-auto bg-blue-200 px-3 py-3 rounded mb-3">
                <p>Nama : {{ $dataMahasiswa->name }}</p>
                <p>NIM : {{ $dataMahasiswa->nim }}</p>
                <p>Periode : {{ $laporan->periodeSemester?->tahun_akademik }} {{ $laporan->periodeSemester?->semester }}
                </p>
                <p>Dibuat : {{ $laporan->created_at->translatedFormat('d F Y') }}</p>
                <p>Status : {{ $laporan->status }}</p>
            </div>

            @if (session('success'))
                <div class="bg-green-100 w-auto px-3 py-3 rounded mb-3">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="bg-red-200 w-auto px-3 py-3 rounded mb-3">
                    {{ session('fails') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-2 rounded mb-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="">
                {{-- Reports --}}
                <div x-cloak x-data="{ openReports: false, openEditReports: false, editDataReports: {} }" class="overflow-x-auto mb-2 mt-5 cursor-default"
                    x-on:edit-reports.window="editDataReports = $event.detail; openEditReports = true">
                    <h2 class="text-xl font-bold text-[#013F4E]">A. KEGIATAN AKADEMIK</h2>
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Nilai IPS dan IPK Semester Ini
                    </p>

                    {{-- Panggil komponen tabel --}}
                    <x-tabel :headers="['No', 'Semester', 'IPS', 'IPK', 'Bukti', 'Status']" :columns="['semester', 'ips', 'ipk', 'bukti', 'status']" :rows="$parsingAcademicReports" idKey="id"
                        editEvent="edit-reports" :status="$laporan->status" />

                    @if (!$parsingAcademicReports && $laporan->status === 'Draft')
                        {{-- Btn tambah data --}}
                        <button @click="openReports = true"
                            class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                            Tambah
                        </button>
                        {{-- Modal tambah data --}}
                        <x-modal title="Tambah data IPS dan IPK" show="openReports">
                            <form method="POST"
                                action="{{ route('laporan.academic-reports.store', $laporan->laporan_id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Semester <span
                                            class="text-red-500">*</span></label>
                                    <select name="semester"
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
                                    <label class="block text-sm font-medium">IPS <span
                                            class="text-red-500">*</span></label>
                                    <span class="text-[2pt] text-red-500 italic">Maks 4.00</span>
                                    <input type="number" name="ips"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                        step="0.01" min="0" max="4">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">IPK <span
                                            class="text-red-500">*</span></label>
                                    <span class="text-[2pt] text-red-500 italic">Maks 4.00</span>
                                    <input type="number" name="ipk"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                        step="0.01" min="0" max="4">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Bukti <span
                                            class="text-red-500">*</span></label>
                                    <input type="file" name="bukti"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openReports = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                        {{-- Modal edit data --}}
                        <x-modal title="Edit data IPS dan IPK" show="openEditReports">
                            <form
                                x-bind:action="'{{ route('laporan.academic-reports.update', ':id') }}'.replace(':id', editDataReports
                                    .id)"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label>Semester</label>
                                    <select name="semester" x-model="editDataReports.semester"
                                        class="w-full border rounded px-2 py-1">
                                        <template x-for="n in 8" :key="n">
                                            <option x-bind:value="n" x-text="n"></option>
                                        </template>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>IPS</label>
                                    <input type="number" name="ips" x-model="editDataReports.ips"
                                        class="w-full border rounded px-2 py-1" step="0.01" min="0"
                                        max="4">
                                </div>
                                <div class="mb-3">
                                    <label>IPK</label>
                                    <input type="number" name="ipk" x-model="editDataReports.ipk"
                                        class="w-full border rounded px-2 py-1" step="0.01" min="0"
                                        max="4">
                                </div>
                                <div class="mb-3">
                                    <label>Bukti</label>
                                    <input type="file" name="bukti" class="w-full border rounded px-2 py-1">
                                    <div class="text-sm mt-1" x-show="editDataReports.bukti">
                                    </div>
                                </div>
                                {{-- btn --}}
                                <div>
                                    <button type="button" @click="openEditReports = false"
                                        class="px-3 py-1 border rounded">
                                        Batal
                                    </button>
                                    <button type="submit" class="px-3 py-1 rounded bg-[#09697E] text-white">
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </x-modal>
                    @endif
                </div>

                {{-- Academic Activities --}}
                <div x-cloak x-data="{ openAcademic: false, openEditAcademic: false, editDataAcademy: {} }" class="overflow-x-auto mb-2 cursor-default"
                    x-on:edit-academic.window="editDataAcademy = $event.detail; openEditAcademic = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Kegiatan Akademik</p>

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
                        editEvent="edit-academic" :status="$laporan->status" />

                    @if ($laporan->status === 'Draft')
                        <button @click="openAcademic = true"
                            class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                            Tambah
                        </button>

                        {{-- Tambah Modal --}}
                        <x-modal title="Tambah Data Kegiatan Akademik" show="openAcademic">
                            <form method="POST"
                                action="{{ route('laporan.academic-activities.store', $laporan->laporan_id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama Kegiatan <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="nama-kegiatan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tipe Kegiatan <span
                                            class="text-red-500">*</span></label>
                                    <select name="tipe-kegiatan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
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
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                        <option value="Peserta">Peserta</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tempat</label>
                                    <input type="text" name="tempat"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Mulai</label>
                                    <input type="date" name="tanggal-mulai"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Selesai</label>
                                    <input type="date" name="tanggal-selesai"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Bukti
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <input type="file" name="bukti"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openAcademic = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>

                        {{-- Edit Modal --}}
                        <x-modal title="Edit data Kegiatan Akademik" show="openEditAcademic">
                            <form method="POST"
                                x-bind:action="'{{ route('laporan.academic-activities.update', ':id') }}'.replace(':id',
                                    editDataAcademy
                                    .id)"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama Kegiatan <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="nama-kegiatan"
                                        x-model="editDataAcademy['activity-name']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tipe Kegiatan <span
                                            class="text-red-500">*</span></label>
                                    <select name="tipe-kegiatan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                        x-model="editDataAcademy['activity-type']">
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
                                        <option value="Peserta">Peserta</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tempat</label>
                                    <input type="text" name="tempat" x-model="editDataAcademy['place']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Mulai</label>
                                    <input type="date" name="tanggal-mulai"
                                        x-model="editDataAcademy['start-date']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Selesai</label>
                                    <input type="date" name="tanggal-selesai"
                                        x-model="editDataAcademy['end-date']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Bukti
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <input type="file" name="bukti"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openEditAcademic = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                    @endif

                </div>

                {{-- Organization Activities --}}
                <div x-cloak x-data="{ openOrganization: false, openEditOrg: false, editDataOrg: {} }" class="overflow-x-auto mb-2 cursor-default"
                    x-on:edit-org.window="editDataOrg = $event.detail; openEditOrg = true">
                    <h2 class="text-xl font-bold text-[#013F4E]">B. KEGIATAN NON-AKADEMIK</h2>
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Kegiatan Organisasi Mahasiswa</p>

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
                    ]" :rows="$parsingOrganizationActivities" idKey="id"
                        editEvent="edit-org" :status="$laporan->status" />

                    @if ($laporan->status === 'Draft')
                        {{-- Btn --}}
                        <button @click="openOrganization = true"
                            class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                            Tambah
                        </button>

                        {{-- Modal Tambah --}}
                        <x-modal title="Tambah data kegiatan organisasi" show="openOrganization">
                            <form method="POST" enctype="multipart/form-data"
                                action="{{ route('laporan.org-activities.store', $laporan->laporan_id) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama UKM <span
                                            class="text-red-500">*</span></label>
                                    <select name="nama-ukm"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
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
                                    <input type="text" name="nama-kegiatan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tingkat <span
                                            class="text-red-500">*</span></label>
                                    <select name="tingkat"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                        <option value="" class="italic">Pilih Tingkat</option>
                                        <option value="Perguruan Tinggi">Perguruan Tinggi</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Posisi <span
                                            class="text-red-500">*</span></label>
                                    <select name="posisi"
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
                                    <label class="block text-sm font-medium">Tempat</label>
                                    <input type="text" name="tempat"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Mulai</label>
                                    <input type="date" name="tanggal-mulai"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Selesai</label>
                                    <input type="date" name="tanggal-selesai"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Bukti <span
                                            class="text-red-500">*</span></label>
                                    <input type="file" name="bukti"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openOrganization = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>

                        {{-- Modal Edit --}}
                        <x-modal title="Edit data kegiatan organisasi" show="openEditOrg">
                            <form method="POST"
                                x-bind:action="'{{ route('laporan.org-activities.update', ':id') }}'.replace(':id', editDataOrg.id)"
                                enctype="multipart/form-data">
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
                                    <label class="block text-sm font-medium">Tempat</label>
                                    <input type="text" name="tempat" x-model="editDataOrg['place']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Mulai</label>
                                    <input type="date" name="tanggal-mulai" x-model="editDataOrg['start-date']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Selesai</label>
                                    <input type="date" name="tanggal-selesai" x-model="editDataOrg['end-date']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Bukti <span
                                            class="text-red-500">*</span></label>
                                    <input type="file" name="bukti"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openEditOrg = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                    @endif
                </div>

                {{-- Committee Activities --}}
                <div x-cloak x-data="{ openCommittee: false, openEditCommittee: false, editDataCommittee: {} }" class="overflow-x-auto mb-2 cursor-default"
                    x-on:edit-committee.window="editDataCommittee = $event.detail; openEditCommittee = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Kegiatan Kepanitiaan Atau Penugasan</p>

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
                        editEvent="edit-committee" :status="$laporan->status" />

                    @if ($laporan->status === 'Draft')
                        <button @click="openCommittee = true"
                            class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                            Tambah
                        </button>

                        {{-- Modal Tambah --}}
                        <x-modal title="Tambah Data Kegiatan Penugasan dan Kepanitian" show="openCommittee">
                            <form method="POST" enctype="multipart/form-data"
                                action="{{ route('laporan.committee-activities.store', $laporan->laporan_id) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama Kegiatan</label>
                                    <input type="text" name="nama-kegiatan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tipe Kegiatan</label>
                                    <input type="text" name="tipe-kegiatan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Keikutsertaan</label>
                                    <input type="text" name="keikutsertaan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tingkat</label>
                                    <input type="text" name="tingkat"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tempat</label>
                                    <input type="text" name="tempat"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Mulai</label>
                                    <input type="date" name="tanggal-mulai"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Selesai</label>
                                    <input type="date" name="tanggal-selesai"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Bukti</label>
                                    <input type="file" name="bukti"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openCommittee = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>

                        {{-- Modal Edit --}}
                        <x-modal title="Tambah Data Kegiatan Penugasan dan Kepanitian" show="openEditCommittee">
                            <form method="POST" enctype="multipart/form-data"
                                x-bind:action="'{{ route('laporan.committee-activities.update', ':id') }}'.replace(':id',
                                    editDataCommittee.id)">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama Kegiatan</label>
                                    <input type="text" name="nama-kegiatan"
                                        x-model="editDataCommittee['activity-name']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tipe Kegiatan</label>
                                    <input type="text" name="tipe-kegiatan"
                                        x-model="editDataCommittee['activity-type']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Keikutsertaan</label>
                                    <input type="text" name="keikutsertaan"
                                        x-model="editDataCommittee['participation']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tingkat</label>
                                    <input type="text" name="tingkat" x-model="editDataCommittee['level']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tempat</label>
                                    <input type="text" name="tempat" x-model="editDataCommittee['place']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Mulai</label>
                                    <input type="date" name="tanggal-mulai"
                                        x-model="editDataCommittee['start-date']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Selesai</label>
                                    <input type="date" name="tanggal-selesai"
                                        x-model="editDataCommittee['end-date']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Bukti</label>
                                    <input type="file" name="bukti"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openEditCommittee = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                    @endif
                </div>

                {{-- Achievements --}}
                <div x-cloak x-data="{ openAchievement: false, openEditAchievement: false, editDataAchievement: {} }" class="overflow-x-auto mb-2 cursor-default"
                    x-on:edit-achievement.window="editDataAchievement = $event.detail; openEditAchievement = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Prestasi Mahasiswa</p>

                    <x-tabel :headers="[
                        'No',
                        'Nama Prestasi',
                        'Cakupan',
                        'Kelompok/Individu',
                        'Tingkat',
                        'Juara',
                        'Tempat',
                        'Tanggal Mulai',
                        'Tanggal Selesai',
                        'Bukti',
                        'Status',
                    ]" :columns="[
                        'achievements-name',
                        'scope',
                        'is-group',
                        'level',
                        'award',
                        'place',
                        'start-date',
                        'end-date',
                        'bukti',
                        'status',
                    ]" :rows="$parsingAchievements" idKey="id"
                        editEvent="edit-achievement" :status="$laporan->status" />

                    @if ($laporan->status === 'Draft')
                        <button @click="openAchievement = true"
                            class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                            Tambah
                        </button>

                        {{-- Modal Tambah --}}
                        <x-modal title="Tambah Data Prestasi" show="openAchievement">
                            <form method="POST" enctype="multipart/form-data"
                                action="{{ route('laporan.achievements.store', $laporan->laporan_id) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama Prestasi</label>
                                    <input type="text" name="nama-prestasi"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Cakupan</label>
                                    <select name="cakupan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                        <option value="" class="italic">Pilih Cakupan</option>
                                        <option value="Pemerintahan">Pemerintahan</option>
                                        <option value="Non-Pemerintahan">Non-Pemerintahan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Kelompok/Individu</label>
                                    <select name="kelompok-individu">
                                        <option value="1">Kelompok</option>
                                        <option value="0">Individu</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tingkat</label>
                                    <select name="tingkat">
                                        <option value="Internasional">Internasional</option>
                                        <option value="Nasional">Nasional</option>
                                        <option value="Regional">Regional</option>
                                        <option value="Perguruan Tinggi">Perguruan Tinggi</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Raihan</label>
                                    <select name="raihan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                        <option value="" class="italic">Pilih Juara</option>
                                        <option value="Juara 1">Juara 1</option>
                                        <option value="Juara 2">Juara 2</option>
                                        <option value="Juara 3">Juara 3</option>
                                        <option value="Juara Harapan">Juara Harapan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tempat</label>
                                    <input type="text" name="tempat"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Mulai</label>
                                    <input type="date" name="tanggal-mulai"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Selesai</label>
                                    <input type="date" name="tanggal-selesai"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Bukti</label>
                                    <input type="file" name="bukti"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openAchievement = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>

                        {{-- Modal Edit --}}
                        <x-modal title="Edit Data Prestasi" show="openEditAchievement">
                            <form method="POST" enctype="multipart/form-data"
                                x-bind:action="'{{ route('laporan.achievements.update', ':id') }}'.replace(':id', editDataAchievement
                                    .id)">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama Prestasi</label>
                                    <input type="text" name="nama-prestasi"
                                        x-model="editDataAchievement['achievements-name']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Cakupan</label>
                                    <select name="cakupan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                        x-model="editDataAchievement['scope']">
                                        <option value="" class="italic">Pilih Cakupan</option>
                                        <option value="Pemerintahan">Pemerintahan</option>
                                        <option value="Non-Pemerintahan">Non-Pemerintahan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Kelompok/Individu</label>
                                    <select name="kelompok-individu"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                        x-model="editDataAchievement['is-group']">
                                        <option value="1">Kelompok</option>
                                        <option value="0">Individu</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tingkat</label>
                                    <select name="tingkat"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                        x-model="editDataAchievement['level']">
                                        <option value="Internasional">Internasional</option>
                                        <option value="Nasional">Nasional</option>
                                        <option value="Regional">Regional</option>
                                        <option value="Perguruan Tinggi">Perguruan Tinggi</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Raihan</label>
                                    <select name="raihan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                        x-model="editDataAchievement['award']">
                                        <option value="" class="italic">Pilih Juara</option>
                                        <option value="Juara 1">Juara 1</option>
                                        <option value="Juara 2">Juara 2</option>
                                        <option value="Juara 3">Juara 3</option>
                                        <option value="Juara Harapan">Juara Harapan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tempat</label>
                                    <input type="text" name="tempat" x-model="editDataAchievement['place']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Mulai</label>
                                    <input type="date" name="tanggal-mulai"
                                        x-model="editDataAchievement['start-date']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Selesai</label>
                                    <input type="date" name="tanggal-selesai"
                                        x-model="editDataAchievement['end-date']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Bukti</label>
                                    <input type="file" name="bukti"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openEditAchievement = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                    @endif

                </div>

                {{-- Independent Activities --}}
                <div x-cloak x-data="{ openIndependent: false, openEditIndependent: false, editDataIndependent: {} }" class="overflow-x-auto mb-2 cursor-default"
                    x-on:edit-independent="editDataIndependent = $event.detail; openEditIndependent = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Kegiatan Mandiri Mahasiswa Selama Satu
                        Semester</p>
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
                        editEvent="edit-independent" :status="$laporan->status" />

                    @if ($laporan->status === 'Draft')
                        <button @click="openIndependent = true"
                            class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                            Tambah
                        </button>
                        {{-- Modal Tambah --}}
                        <x-modal title="Tambah Data Kegiatan Mandiri" show="openIndependent">
                            <form method="POST" enctype="multipart/form-data"
                                action="{{ route('laporan.independent-activities.store', $laporan->laporan_id) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama Kegiatan</label>
                                    <input type="text" name="nama-kegiatan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tipe Kegiatan</label>
                                    <input type="text" name="tipe-kegiatan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Keikutsertaan</label>
                                    <input type="text" name="keikutsertaan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tempat</label>
                                    <input type="text" name="tempat"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Mulai</label>
                                    <input type="date" name="tanggal-mulai"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Selesai</label>
                                    <input type="date" name="tanggal-selesai"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Bukti</label>
                                    <input type="file" name="bukti"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openIndependent = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                        {{-- Modal Edit --}}
                        <x-modal title="Edit Data Kegiatan Mandiri" show="openEditIndependent">
                            <form method="POST" enctype="multipart/form-data"
                                x-bind:action="'{{ route('laporan.independent-activities.update', ':id') }}'.replace(':id',
                                    editDataIndependent.id)">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama Kegiatan</label>
                                    <input type="text" name="nama-kegiatan"
                                        x-model="editDataIndependent['activity-name']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tipe Kegiatan</label>
                                    <input type="text" name="tipe-kegiatan"
                                        x-model="editDataIndependent['activity-type']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Keikutsertaan</label>
                                    <input type="text" name="keikutsertaan"
                                        x-model="editDataIndependent['participation']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tempat</label>
                                    <input type="text" name="tempat" x-model="editDataIndependent['place']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Mulai</label>
                                    <input type="date" name="tanggal-mulai"
                                        x-model="editDataIndependent['start-date']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tanggal Selesai</label>
                                    <input type="date" name="tanggal-selesai"
                                        x-model="editDataIndependent['end-date']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Bukti</label>
                                    <input type="file" name="bukti"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openEditIndependent = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                    @endif
                </div>

                {{-- Evaluations --}}
                <div x-cloak x-data="{ openEvaluation: false, openEditEvaluation: false, editDataEvaluation: {} }" class="overflow-x-auto mb-2 mt-4 cursor-default">
                    <h2 class="text-xl font-bold text-[#013F4E]">C. EVALUASI</h2>
                    {{-- Data yg ditampilkan --}}
                    <div>
                        <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Faktor Pendukung</p>
                        <textarea name="faktor-pendukung" id="faktor-pendukung"
                            class="resize-none px-2 py-0.5 w-[450px] h-[200px] cursor-default shadow-md border border-[#c0c0c0] focus:outline-none focus:ring-0"
                            readonly>{{ $parsingEvaluations->support_factors ?? '-' }}</textarea>
                    </div>
                    <div>
                        <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Faktor Penghambat</p>
                        <textarea name="faktor-pendukung" id=""
                            class="resize-none px-2 py-0.5 w-[450px] h-[200px] cursor-default shadow-md border border-[#c0c0c0] focus:outline-none focus:ring-0"
                            readonly>{{ $parsingEvaluations->barrier_factors ?? '-' }}</textarea>
                    </div>

                    @if ($parsingEvaluations && $laporan->sttaus === 'Draft')
                        <button x-data='{ eval: @json($parsingEvaluations) }'
                            @click="
                                openEditEvaluation = true;
                                editDataEvaluation = eval;
                            "
                            class="border border-black mt-2 px-2 rounded-lg">
                            Edit
                        </button>
                    @elseif (!$parsingEvaluations && $laporan->sttaus === 'Draft')
                        <button @click="openEvaluation = true"
                            class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                            Tambah
                        </button>
                    @endif

                    {{-- Modal Tambah --}}
                    <x-modal title="Tambah Data Evaluasi" show="openEvaluation">
                        <form method="POST" action="{{ route('laporan.evaluations.store', $laporan->laporan_id) }}">
                            @csrf
                            <div class="mb-3">
                                <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Faktor Pendukung</p>
                                <textarea name="faktor-pendukung" id="faktor-pendukung"
                                    class="resize-none px-2 py-0.5 w-full h-[200px] cursor-pointer shadow-md border border-[#c0c0c0] focus:outline-none focus:ring-0"
                                    placeholder="Tuliskan faktor pendukungmu disini...">x</textarea>
                            </div>
                            <div class="mb-3">
                                <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Faktor Penghambat</p>
                                <textarea name="faktor-penghambat" id="faktor-penghambat"
                                    class="resize-none px-2 py-0.5 w-full h-[200px] cursor-pointer shadow-md border border-[#c0c0c0] focus:outline-none focus:ring-0"
                                    placeholder="Tuliskan faktor penghambatmu disini..."></textarea>
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openEvaluation = false"
                                    class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                <button type="submit"
                                    class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                            </div>
                        </form>
                    </x-modal>

                    {{-- Modal Edit --}}
                    <x-modal title="Edit Data Evaluasi" show="openEditEvaluation">
                        <form method="POST"
                            x-bind:action="'{{ route('laporan.evaluations.update', ':id') }}'.replace(':id', editDataEvaluation.id)">
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
                                    class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                <button type="submit"
                                    class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                            </div>
                        </form>
                    </x-modal>
                </div>

                {{-- Target Next SMT --}}
                <div x-cloak x-data="{ openTargetRep: false, openEditTargetRep: false, editDataTargetRep: {} }" class="overflow-x-auto mb-2 mt-2 cursor-default"
                    x-on:edit-target-rep.window="editDataTargetRep = $event.detail; openEditTargetRep = true">
                    <h2 class="text-xl font-bold text-[#013F4E]">D. TARGET SEMESTER DEPAN</h2>
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Rencana Nilai IPS dan IPK
                        Semester
                        Depan
                    </p>

                    <x-tabel :headers="['No', 'Semester', 'Target IPS', 'Target IPK', 'Status']" :columns="['semester', 'target-ips', 'target-ipk', 'status']" :rows="$parsingNextReports" idKey="id"
                        editEvent="edit-target-rep" :status="$laporan->status" />

                    @if ($laporan->status === 'Draft')
                        <button @click="openTargetRep = true"
                            class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                            Tambah
                        </button>
                        {{-- Modal Tambah --}}
                        <x-modal title="Tambah Data Target IPS dan IPK" show="openTargetRep">
                            <form method="POST"
                                action="{{ route('laporan.next-semester-reports.store', $laporan->laporan_id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Semester <span
                                            class="text-red-500">*</span></label>
                                    <select name="semester"
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
                                    <input type="number" name="target-ips"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                        step="0.01" min="0" max="4">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Target IPK <span
                                            class="text-red-500">*</span></label>
                                    <span class="text-[2pt] text-red-500 italic">Maks 4.00</span>
                                    <input type="number" name="target-ipk"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                        step="0.01" min="0" max="4">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openTargetRep = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                        {{-- Modal Edit --}}
                        <x-modal title="Edit Data Rencana IPS dan IPK" show="openEditTargetRep">
                            <form
                                x-bind:action="'{{ route('laporan.next-semester-reports.update', ':id') }}'.replace(':id',
                                    editDataTargetRep.id)"
                                method="POST">
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
                                        class="px-3 py-1 border rounded">
                                        Batal
                                    </button>
                                    <button type="submit" class="px-3 py-1 rounded bg-[#09697E] text-white">
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </x-modal>
                    @endif
                </div>

                {{-- Target Keg Akademik --}}
                <div x-cloak x-data="{ openTargetAcademic: false, openEditTargetAcademic: false, editDataTargetAcademic: {} }" class="overflow-x-auto mb-2 cursor-default"
                    x-on:edit-target-academic.window="editDataTargetAcademic = $event.detail; openEditTargetAcademic = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Rencana Kegiatan Akademik
                        Semester
                        Depan
                    </p>

                    <x-tabel :headers="['No', 'Nama Kegiatan', 'Rencana/Strategi', 'Status']" :columns="['activity-name', 'strategy', 'status']" :rows="$parsingNextAcademicActivities" idKey="id"
                        editEvent="edit-target-academic" :status="$laporan->status" />

                    @if ($laporan->status === 'Draft')
                        <button @click="openTargetAcademic = true"
                            class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                            Tambah
                        </button>
                        {{-- Modal tambah --}}
                        <x-modal title="Tambah Data Rencana Kegiatan Akademik" show="openTargetAcademic">
                            <form method="POST"
                                action="{{ route('laporan.next-smt-activities.store', $laporan->laporan_id) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama Kegiatan</label>
                                    <input type="text" name="nama-kegiatan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Rencana/Strategi</label>
                                    <input type="text" name="rencana-strategi"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Keikutsertaan</label>
                                    <input type="text" name="keikutsertaan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openTargetAcademic = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                        {{-- Modal Edit --}}
                        <x-modal title="Edit Data Rencana Kegiatan Akademik" show="openEditTargetAcademic">
                            <form method="POST"
                                x-bind:action="'{{ route('laporan.next-smt-activities.update', ':id') }}'.replace(':id',
                                    editDataTargetAcademic.id)">
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
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                    @endif
                </div>

                {{-- Target Achievements --}}
                <div x-cloak x-data="{ openTargetAchievement: false, openEditTargetAchievement: false, editDatatargetAchievement: {} }" class="overflow-x-auto mb-2 cursor-default"
                    x-on:edit-target-achievement="editDatatargetAchievement = $event.detail; openEditTargetAchievement = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Rencana Prestasi</p>

                    <x-tabel :headers="['No', 'Nama Prestasi', 'Tingkat', 'Raihan', 'Status']" :columns="['achievements-name', 'level', 'award', 'status']" :rows="$parsingNextAchievements" idKey="id"
                        editEvent="edit-target-achievement" :status="$laporan->status" />

                    @if ($laporan->status === 'Draft')
                        <button @click="openTargetAchievement = true"
                            class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                            Tambah
                        </button>
                        {{-- Modal Tambah --}}
                        <x-modal title="Tambah Data Rencana Prestasi" show="openTargetAchievement">
                            <form method="POST"
                                action="{{ route('laporan.next-smt-achievements.store', $laporan->laporan_id) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama Prestasi</label>
                                    <input type="text" name="nama-prestasi"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tingkat</label>
                                    <input type="text" name="tingkat"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Raihan</label>
                                    <input type="text" name="raihan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openTargetAchievement = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                        {{-- Modal Edit --}}
                        <x-modal title="Edit Data Rencana Prestasi" show="openEditTargetAchievement">
                            <form method="POST"
                                x-bind:action="'{{ route('laporan.next-smt-achievements.update', ':id') }}'.replace(':id',
                                    editDatatargetAchievement.id)">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama Prestasi</label>
                                    <input type="text" name="nama-prestasi"
                                        x-model="editDatatargetAchievement['achievements-name']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tingkat</label>
                                    <input type="text" name="tingkat"
                                        x-model="editDatatargetAchievement['level']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Raihan</label>
                                    <input type="text" name="raihan"
                                        x-model="editDatatargetAchievement['award']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openEditTargetAchievement = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                    @endif
                </div>

                {{-- Target Independent --}}
                <div x-cloak x-data="{ openTargetIndependent: false, openEditTargetIndependent: false, editDataTargetIndependent: {} }" class="overflow-x-auto mb-2 cursor-default"
                    x-on:edit-target-independent="editDataTargetIndependent = $event.detail; openEditTargetIndependent = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Rencana Kegiatan Mandiri</p>

                    <x-tabel :headers="['No', 'Nama Kegiatan', 'Rencana/Strategi', 'Keikutsertaan', 'Status']" :columns="['activity-name', 'strategy', 'participation', 'status']" :rows="$parsingNextIndependentActivities" idKey="id"
                        editEvent="edit-target-independent" :status="$laporan->status" />

                    @if ($laporan->status === 'Draft')
                        <button @click="openTargetIndependent = true"
                            class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                            Tambah
                        </button>
                        {{-- Modal tambah --}}
                        <x-modal title="Tambah Data Rencana Kegiatan Mandiri" show="openTargetIndependent">
                            <form method="POST"
                                action="{{ route('laporan.next-smt-independent.store', $laporan->laporan_id) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama Kegiatan</label>
                                    <input type="text" name="nama-kegiatan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Rencana/Strategi</label>
                                    <input type="text" name="rencana-strategi"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Keikutsertaan</label>
                                    <input type="text" name="keikutsertaan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openTargetIndependent = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                        {{-- Modal Edit --}}
                        <x-modal title="Tambah Data Rencana Kegiatan Mandiri" show="openEditTargetIndependent">
                            <form method="POST"
                                x-bind:action="'{{ route('laporan.next-smt-independent.update', ':id') }}'.replace(':id',
                                    editDataTargetIndependent.id)">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama Kegiatan</label>
                                    <input type="text" name="nama-kegiatan"
                                        x-model="editDataTargetIndependent['activity-name']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Rencana/Strategi</label>
                                    <input type="text" name="rencana-strategi"
                                        x-model="editDataTargetIndependent['strategy']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Keikutsertaan</label>
                                    <input type="text" name="keikutsertaan"
                                        x-model="editDataTargetIndependent['participation']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openEditTargetIndependent = false"
                                        class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                    @endif
                </div>
            </div>

            <form action="{{ route('laporan.ajukan', $laporan->laporan_id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                {{-- btn ajukan dan kembali --}}
                <div class="mt-4 flex gap-2">
                    <button type="button" class="button bg-gray-300 px-2 py-1 rounded-md cursor-pointer">
                        <a href="{{ route('mahasiswa.dashboard') }}">Kembali</a>
                    </button>
                    <button type="submit"
                        class="button bg-gray-300 px-2 py-1 rounded-md cursor-pointer">Ajukan</button>
                </div>
            </form>
        </div>
    </section>
</body>

</html>

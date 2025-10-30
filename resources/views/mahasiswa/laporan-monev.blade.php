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
    <title>Isi Laporan Monev</title>
</head>

<body class="bg-[#F8F6F6]">
    <x-navbar-mhs mhsAvatar='{{ $dataMahasiswa->avatar }}' />

    <section class="flex justify-center w-full h-auto">
        <div class="bg-[#fdfdfd] w-[1100px] h-auto p-6">
            <h2 class="text-xl font-bold ml-3 mb-2">Laporan Monev Yang Tersimpan</h2>
            <div class="h-auto bg-blue-200 ml-3 mr-3 px-3 py-3 rounded mb-3">
                <p>Nama : {{ $dataMahasiswa->name }}</p>
                <p>NIM : {{ $dataMahasiswa->nim }}</p>
                <p>Periode : {{ $laporan->periodeSemester?->tahun_akademik }} {{ $laporan->periodeSemester?->semester }}
                </p>
                <p>Dibuat : {{ $laporan->created_at->translatedFormat('d F Y') }}</p>
                <p>Status : {{ $laporan->status }}</p>
            </div>

            @if (session('success'))
                <div class="bg-green-100 mx-3 w-auto px-3 py-3 rounded mb-3">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="bg-red-200 w-auto mx-3 px-3 py-3 rounded mb-3">
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
                <div x-cloak x-data="{ openReports: false, openEditReports: false, editDataReports: {} }" class="mb-3 mt-5 pr-3 cursor-default"
                    x-on:edit-reports.window="editDataReports = $event.detail; openEditReports = true">
                    <h2 class="text-xl font-bold text-[#013F4E] ml-3">A. KEGIATAN AKADEMIK</h2>
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5 ml-3">Nilai IPS dan IPK Semester Ini
                    </p>

                    <div class="overflow-x-auto">
                        {{-- Panggil komponen tabel --}}
                        <x-tabel :headers="['No', 'Semester', 'IPS', 'IPK', 'Bukti', 'Status']" :columns="['semester', 'ips', 'ipk', 'bukti', 'status']" :rows="$parsingAcademicReports" idKey="id"
                            editEvent="edit-reports" deleteRoute="laporan.academic-reports.delete" :status="$laporan->status"
                            style="draft" />
                    </div>

                    @if ($laporan->status === 'Draft')
                        @if (!$parsingAcademicReports || count($parsingAcademicReports) === 0)
                            {{-- Btn tambah data --}}
                            <button @click="openReports = true"
                                class="bg-[#dfdfdf] ml-3 mt-2 px-2 py-0.75 rounded-lg hover:bg-[#eeeeee] transition cursor-pointer">
                                Tambah
                            </button>
                        @endif

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
                                        <option value="{{ $laporan->semester }}">{{ $laporan->semester }}</option>
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
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                        {{-- Modal edit data --}}
                        <x-modal title="Edit data IPS dan IPK" show="openEditReports">
                            <form
                                x-bind:action="'{{ route('laporan.academic-reports.update', ':id') }}'.replace(':id',
                                    editDataReports
                                    .id)"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label>Semester</label>
                                    <select name="semester" x-model="editDataReports.semester"
                                        class="w-full border rounded px-2 py-1">
                                        <option value="{{ $laporan->semester }}">{{ $laporan->semester }}</option>
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
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </x-modal>
                        {{-- Delete Modal --}}
                        <x-modal-delete deleteRoute="laporan.academic-reports.delete" />
                    @endif
                </div>

                {{-- Academic Activities --}}
                <div x-cloak x-data="{ openAcademic: false, openEditAcademic: false, editDataAcademy: {} }" class="mb-2 pr-3 cursor-default"
                    x-on:edit-academic.window="editDataAcademy = $event.detail; openEditAcademic = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5 ml-3">Kegiatan Akademik</p>

                    <div class="overflow-x-auto">
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
                            editEvent="edit-academic" deleteRoute="laporan.academic-activities.delete"
                            :status="$laporan->status" style="draft" />
                    </div>

                    @if ($laporan->status === 'Draft')
                        <button @click="openAcademic = true"
                            class="bg-[#dfdfdf] ml-3 mt-2 px-2 py-0.75 rounded-lg hover:bg-[#eeeeee] transition cursor-pointer">
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
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                        <option value="" class="italic">Pilih Keikutsertaan</option>
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
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
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
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                    @endif
                </div>

                {{-- Organization Activities --}}
                <div x-cloak x-data="{ openOrganization: false, openEditOrg: false, editDataOrg: {} }" class="mb-2 pr-3 cursor-default"
                    x-on:edit-org.window="editDataOrg = $event.detail; openEditOrg = true">
                    <h2 class="text-xl font-bold text-[#013F4E] ml-3 mt-4">B. KEGIATAN NON-AKADEMIK</h2>
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5 ml-3">Kegiatan Organisasi Mahasiswa</p>

                    <div class="overflow-x-auto">
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
                            editEvent="edit-org" deleteRoute="laporan.org-activities.delete" :status="$laporan->status"
                            style="draft" />
                    </div>

                    @if ($laporan->status === 'Draft')
                        {{-- Btn --}}
                        <button @click="openOrganization = true"
                            class="bg-[#dfdfdf] ml-3 mt-2 px-2 py-0.75 rounded-lg hover:bg-[#eeeeee] transition cursor-pointer">
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
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
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
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                    @endif
                </div>

                {{-- Committee Activities --}}
                <div x-cloak x-data="{ openCommittee: false, openEditCommittee: false, editDataCommittee: {} }" class="mb-2 pr-3 cursor-default"
                    x-on:edit-committee.window="editDataCommittee = $event.detail; openEditCommittee = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold ml-3 mb-0.5">Kegiatan Kepanitiaan Atau Penugasan
                    </p>

                    <div class="overflow-x-auto">
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
                            editEvent="edit-committee" deleteRoute="laporan.committee-activities.hapus"
                            :status="$laporan->status" style="draft" />
                    </div>

                    @if ($laporan->status === 'Draft')
                        <button @click="openCommittee = true"
                            class="bg-[#dfdfdf] ml-3 mt-2 px-2 py-0.75 rounded-lg hover:bg-[#eeeeee] transition cursor-pointer">
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
                                    <select name="tipe-kegiatan" id="tipe-kegiatan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                        <option value="">Pilih Satu</option>
                                        <option value="Pelatihan Kepemimpinan">Pelatihan Kepemimpinan</option>
                                        <option value="Panitia Kegiatan Perguruan Tinggi">Panitia Kegiatan Perguruan
                                            Tinggi</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tingkat</label>
                                    <select name="tingkat" id="tingkat"
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
                                    <label class="block text-sm font-medium">Keikutsertaan</label>
                                    <select name="keikutsertaan"
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
                                    <label class="block text-sm font-medium">Bukti</label>
                                    <input type="file" name="bukti"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openCommittee = false"
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
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
                                    <input type="text" name="tipe-kegiatan" id="tipe-kegiatan"
                                        x-model="editDataCommittee['activity-type']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tingkat</label>
                                    <input type="text" name="tingkat" id="tingkat"
                                        x-model="editDataCommittee['level']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Keikutsertaan</label>
                                    <input type="text" name="keikutsertaan"
                                        x-model="editDataCommittee['participation']"
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
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
                                </div>
                            </form>
                        </x-modal>

                        {{-- JS --}}
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
                </div>

                {{-- Achievements --}}
                <div x-cloak x-data="{ openAchievement: false, openEditAchievement: false, editDataAchievement: {} }" class="mb-2 pr-3 cursor-default"
                    x-on:edit-achievement.window="editDataAchievement = $event.detail; openEditAchievement = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold ml-3 mb-0.5">Prestasi Mahasiswa</p>

                    <div class="overflow-x-auto">
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
                        <button @click="openAchievement = true"
                            class="bg-[#dfdfdf] ml-3 mt-2 px-2 py-0.75 rounded-lg hover:bg-[#eeeeee] transition cursor-pointer">
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
                                    <label class="block text-sm font-medium">Tipe Prestasi</label>
                                    <select name="tipe-prestasi" id="tipe-prestasi"
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
                                    <label class="block text-sm font-medium">Tingkat</label>
                                    <select name="tingkat" id="tingkat-prestasi"
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
                                    <label class="block text-sm font-medium">Raihan</label>
                                    <select name="raihan" id="raihan-prestasi"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                        <option value="Tidak Ada" class="italic">Pilih Juara</option>
                                        <option value="Juara 1">Juara 1</option>
                                        <option value="Juara 2">Juara 2</option>
                                        <option value="Juara 3">Juara 3</option>
                                        <option value="Juara Harapan">Juara Harapan</option>
                                        {{-- Forum Ilmiah, Kegiatan Sosial / Kerohanian,  --}}
                                        <option value="Pembicara">Pembicara</option>
                                        <option value="Moderator">Moderator</option>
                                        <option value="Peserta">Peserta</option>
                                        {{-- Karya Populer/Karya Ilmiah --}}
                                        <option value="Ketua">Ketua</option>
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
                                    <label class="block text-sm font-medium">Bukti</label>
                                    <input type="file" name="bukti"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openAchievement = false"
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
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
                                    <label class="block text-sm font-medium">Tipe Prestasi</label>
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
                                    <label class="block text-sm font-medium">Tingkat</label>
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
                                    <label class="block text-sm font-medium">Raihan</label>
                                    <select name="raihan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                        x-model="editDataAchievement['award']">
                                        <option value="Tidak Ada" class="italic">Pilih Juara</option>
                                        <option value="Juara 1">Juara 1</option>
                                        <option value="Juara 2">Juara 2</option>
                                        <option value="Juara 3">Juara 3</option>
                                        <option value="Juara Harapan">Juara Harapan</option>
                                        {{-- Forum Ilmiah, Kegiatan Sosial / Kerohanian,  --}}
                                        <option value="Pembicara">Pembicara</option>
                                        <option value="Moderator">Moderator</option>
                                        <option value="Peserta">Peserta</option>
                                        {{-- Karya Populer/Karya Ilmiah --}}
                                        <option value="Ketua">Ketua</option>
                                        <option value="Anggota">Anggota</option>
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
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
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
                </div>

                {{-- Independent Activities --}}
                <div x-cloak x-data="{ openIndependent: false, openEditIndependent: false, editDataIndependent: {} }" class="mb-2 pr-3 cursor-default"
                    x-on:edit-independent="editDataIndependent = $event.detail; openEditIndependent = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold ml-3 mb-0.5">Kegiatan Mandiri Mahasiswa Selama
                        Satu
                        Semester</p>

                    <div class="overflow-x-auto">
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
                            editEvent="edit-independent" deleteRoute="laporan.independent-activities.hapus"
                            :status="$laporan->status" style="draft" />
                    </div>

                    @if ($laporan->status === 'Draft')
                        <button @click="openIndependent = true"
                            class="bg-[#dfdfdf] ml-3 mt-2 px-2 py-0.75 rounded-lg hover:bg-[#eeeeee] transition cursor-pointer">
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
                                    <select type="text" name="tipe-kegiatan"
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
                                    <label class="block text-sm font-medium">Keikutsertaan</label>
                                    <select type="text" name="keikutsertaan"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                        <option value="" class="italic">Pilih Keikutsertaan</option>
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
                                    <label class="block text-sm font-medium">Bukti</label>
                                    <input type="file" name="bukti"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openIndependent = false"
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
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
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                    @endif
                </div>

                {{-- Evaluations --}}
                <div x-cloak x-data="{ openEvaluation: false, openEditEvaluation: false, editDataEvaluation: {} }" class="pl-3 mb-2 mt-4 cursor-default">
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
                        <div class="flex gap-4">
                            <button x-data='{ eval: @json($parsingEvaluations) }'
                                @click="
                                openEditEvaluation = true;
                                editDataEvaluation = eval;
                            "
                                class="border border-black mt-2 px-2 rounded-lg">
                                Edit
                            </button>
                            <button
                                @click="
                                openEditEvaluation = true;
                                editDataEvaluation = eval;
                            "
                                class="border border-black mt-2 px-2 rounded-lg">
                                Hapus
                            </button>
                        </div>
                    @elseif (!$parsingEvaluations || $laporan->sttaus === 'Draft')
                        <button @click="openEvaluation = true"
                            class="bg-[#dfdfdf] mt-2 px-2 py-0.75 rounded-lg hover:bg-[#eeeeee] transition cursor-pointer">
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
                                    class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                <button type="submit"
                                    class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
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
                                    class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                <button type="submit"
                                    class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
                            </div>
                        </form>
                    </x-modal>
                </div>

                {{-- Target Next SMT --}}
                <div x-cloak x-data="{ openTargetRep: false, openEditTargetRep: false, editDataTargetRep: {} }" class="mb-2 mt-2 pr-3 cursor-default"
                    x-on:edit-target-rep.window="editDataTargetRep = $event.detail; openEditTargetRep = true">
                    <h2 class="text-xl font-bold text-[#013F4E] mt-4 ml-3">D. TARGET SEMESTER DEPAN</h2>
                    <p class="text-[#013F4E] text-[14pt] font-semibold ml-3 mb-0.5">Rencana Nilai IPS dan IPK
                        Semester
                        Depan
                    </p>

                    <div class="overflow-x-auto">
                        <x-tabel :headers="['No', 'Semester', 'Target IPS', 'Target IPK', 'Status']" :columns="['semester', 'target-ips', 'target-ipk', 'status']" :rows="$parsingNextReports" idKey="id"
                            editEvent="edit-target-rep" deleteRoute="laporan.next-semester-reports.hapus"
                            :status="$laporan->status" style="draft" />
                    </div>

                    @if ($laporan->status === 'Draft')
                        <button @click="openTargetRep = true"
                            class="bg-[#dfdfdf] ml-3 mt-2 px-2 py-0.75 rounded-lg hover:bg-[#eeeeee] transition cursor-pointer">
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
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
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
                                    <input type="number" name="target-ipk"
                                        x-model="editDataTargetRep['target-ipk']"
                                        class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0"
                                        step="0.01" min="0" max="4">
                                </div>
                                {{-- btn --}}
                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="openEditTargetRep = false"
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">
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
                <div x-cloak x-data="{ openTargetAcademic: false, openEditTargetAcademic: false, editDataTargetAcademic: {} }" class="mb-2 pr-3 cursor-default"
                    x-on:edit-target-academic.window="editDataTargetAcademic = $event.detail; openEditTargetAcademic = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold ml-3 mb-0.5">Rencana Kegiatan Akademik
                        Semester
                        Depan
                    </p>

                    <div class="overflow-x-auto">
                        <x-tabel :headers="['No', 'Nama Kegiatan', 'Rencana/Strategi', 'Status']" :columns="['activity-name', 'strategy', 'status']" :rows="$parsingNextAcademicActivities" idKey="id"
                            editEvent="edit-target-academic" deleteRoute="laporan.next-smt-activities.hapus"
                            :status="$laporan->status" style="draft" />
                    </div>

                    @if ($laporan->status === 'Draft')
                        <button @click="openTargetAcademic = true"
                            class="bg-[#dfdfdf] ml-3 mt-2 px-2 py-0.75 rounded-lg hover:bg-[#eeeeee] transition cursor-pointer">
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
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
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
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                    @endif
                </div>

                {{-- Target Achievements --}}
                <div x-cloak x-data="{ openTargetAchievement: false, openEditTargetAchievement: false, editDatatargetAchievement: {} }" class="mb-2 pr-3 cursor-default"
                    x-on:edit-target-achievement="editDatatargetAchievement = $event.detail; openEditTargetAchievement = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold ml-3 mb-0.5">Rencana Prestasi</p>

                    <div class="overflow-x-auto">
                        <x-tabel :headers="['No', 'Nama Prestasi', 'Tingkat', 'Raihan', 'Status']" :columns="['achievements-name', 'level', 'award', 'status']" :rows="$parsingNextAchievements" idKey="id"
                            editEvent="edit-target-achievement" deleteRoute="laporan.next-smt-achievements.hapus"
                            :status="$laporan->status" style="draft" />
                    </div>

                    @if ($laporan->status === 'Draft')
                        <button @click="openTargetAchievement = true"
                            class="bg-[#dfdfdf] ml-3 mt-2 px-2 py-0.75 rounded-lg hover:bg-[#eeeeee] transition cursor-pointer">
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
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
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
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
                                </div>
                            </form>
                        </x-modal>
                    @endif
                </div>

                {{-- Target Independent --}}
                <div x-cloak x-data="{ openTargetIndependent: false, openEditTargetIndependent: false, editDataTargetIndependent: {} }" class="mb-2 pr-3 cursor-default"
                    x-on:edit-target-independent="editDataTargetIndependent = $event.detail; openEditTargetIndependent = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold ml-3 mb-0.5">Rencana Kegiatan Mandiri</p>

                    <div class="overflow-x-auto">
                        <x-tabel :headers="['No', 'Nama Kegiatan', 'Rencana/Strategi', 'Keikutsertaan', 'Status']" :columns="['activity-name', 'strategy', 'participation', 'status']" :rows="$parsingNextIndependentActivities" idKey="id"
                            editEvent="edit-target-independent" deleteRoute="laporan.next-smt-independent.hapus"
                            :status="$laporan->status" style="draft" />
                    </div>

                    @if ($laporan->status === 'Draft')
                        <button @click="openTargetIndependent = true"
                            class="bg-[#dfdfdf] ml-3 mt-2 px-2 py-0.75 rounded-lg hover:bg-[#eeeeee] transition cursor-pointer">
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
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
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
                                        class="px-3 py-1 bg-[#cecece] rounded hover:bg-[#dfdfdf] transition cursor-pointer">Batal</button>
                                    <button type="submit"
                                        class="px-3 py-1 bg-[#09697E] hover:bg-[#10849f] text-white rounded cursor-pointer">Simpan</button>
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
                <div class="ml-3 mt-4 flex gap-2">
                    <button type="button"
                        class="button bg-[#09697E] hover:bg-[#27788a] text-white px-2 py-1 rounded-md cursor-pointer">
                        <a href="{{ route('mahasiswa.dashboard') }}">Kembali</a>
                    </button>
                    <button type="submit"
                        class="button bg-[#44c96a] hover:bg-[#68e28b] px-2 py-1 rounded-md cursor-pointer text-white">Ajukan</button>
                </div>
            </form>
        </div>
    </section>
</body>

</html>

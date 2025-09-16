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
            <div class="w-full h-auto bg-blue-200 mb-2 px-3 py-3 rounded mb-3">
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
            @endif

            <div class="">
                {{-- Reports --}}
                <div x-cloak x-data="{ openReports: false }" class="overflow-x-auto mb-2 mt-5">
                    <h2 class="text-xl font-bold text-[#013F4E]">A. KEGIATAN AKADEMIK</h2>
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Nilai IPS dan IPK Semester Ini
                    </p>
                    <x-tabel :headers="['No', 'Semester', 'IPS', 'IPK', 'Bukti', 'Status', 'Aksi']" :rows="$parsingAcademicReports" />
                    <button @click="openReports = true"
                        class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                        Tambah
                    </button>

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
                                <label class="block text-sm font-medium">IPS <span class="text-red-500">*</span></label>
                                <span class="text-[2pt] text-red-500 italic">Maks 4.00</span>
                                <input type="number" name="ips"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">IPK <span class="text-red-500">*</span></label>
                                <span class="text-[2pt] text-red-500 italic">Maks 4.00</span>
                                <input type="number" name="ipk"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
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
                                <button type="submit" class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                            </div>
                        </form>
                    </x-modal>
                </div>
                {{-- Academic Activities --}}
                <div x-cloak x-data="{ openAcademic: false }" class="overflow-x-auto mb-2">
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
                        'Aksi',
                    ]" :rows="$parsingAcademicActivities" />
                    <button @click="openAcademic = true"
                        class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                        Tambah
                    </button>

                    <x-modal title="Tambah Data Kegiatan Akademik" show="openAcademic">
                        <form method="POST" action="{{ route('laporan.academic-activities.store', $laporan->laporan_id) }}" enctype="multipart/form-data">
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
                </div>

                {{-- Organization Activities --}}
                <div x-cloak x-data="{ openOrganization: false }" class="overflow-x-auto mb-2 mt-4">
                    <h2 class="text-xl font-bold text-[#013F4E]">B. KEGIATAN NON-AKADEMIK</h2>
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Kegiatan Organisasi Mahasiswa
                    </p>
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
                        'Aksi',
                    ]" :rows="$parsingOrganizationActivities" />
                    <button @click="openOrganization = true"
                        class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                        Tambah
                    </button>

                    <x-modal title="Tambah Data Kegiatan Organisasi" show="openOrganization">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('laporan.org-activities.store', $laporan->laporan_id) }}">
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
                                <label class="block text-sm font-medium">Keikutsertaan <span
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
                </div>
                {{-- Committee Activities --}}
                <div x-cloak x-data="{ openCommittee: false }" class="overflow-x-auto mb-2">
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Kegiatan Kepanitiaan Atau
                        Penugasan
                        Mahasiswa</p>
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
                        'Aksi',
                    ]" :rows="$parsingCommitteeActivities" />
                    <button @click="openCommittee = true"
                        class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                        Tambah
                    </button>

                    <x-modal title="Tambah Data Kegiatan Penugasan dan Kepanitian" show="openCommittee">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('laporan.committee-activities.store', $laporan->laporan_id) }}">
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
                                <button type="button" @click="openCommittee = false"
                                    class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                <button type="submit"
                                    class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                            </div>
                        </form>
                    </x-modal>
                </div>
                {{-- Achievements --}}
                <div x-cloak x-data="{ openAchievement: false }" class="overflow-x-auto mb-2">
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
                        'Aksi',
                    ]" :rows="$parsingAchievements" />
                    <button @click="openAchievement = true"
                        class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                        Tambah
                    </button>

                    <x-modal title="Tambah Data Prestasi" show="openAchievement">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('laporan.achievements.store', $laporan->laporan_id) }}">
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
                </div>
                {{-- Independen Activities --}}
                <div x-cloak x-data="{ openIndependent: false }" class="overflow-x-auto mb-2">
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Kegiatan Mandiri Mahasiswa
                        Selama
                        Satu
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
                        'Aksi',
                    ]" :rows="$parsingIndependentActivities" />
                    <button @click="openIndependent = true"
                        class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                        Tambah
                    </button>

                    <x-modal title="Tambah Data Kegiatan Mandiri" show="openIndependent">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('laporan.independent-activities.store', $laporan->laporan_id) }}">
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
                                <input type="text" name="partisipasi"
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
                </div>

                {{-- Evaluation --}}
                <div class="overflow-x-auto mb-2 mt-4">
                    <h2 class="text-xl font-bold text-[#013F4E]">C. EVALUASI</h2>
                    <div>
                        <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Faktor Pendukung</p>
                        <textarea name="faktor-pendukung" id=""
                            class="resize-none px-2 py-0.5 w-[450px] h-[200px] shadow-md border border-[#c0c0c0] focus:outline-none focus:ring-0"
                            placeholder="Tuliskan Faktor Pendukungmu Disini">{{ $laporan->evaluations ?? '' }}</textarea>
                    </div>
                    <div>
                        <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Faktor Penghambat</p>
                        <textarea name="faktor-pendukung" id=""
                            class="resize-none px-2 py-0.5 w-[450px] h-[200px] shadow-md border border-[#c0c0c0] focus:outline-none focus:ring-0"
                            placeholder="Tuliskan Faktor Penghambat Disini">{{ $laporan->evaluations ?? '' }}</textarea>
                    </div>
                </div>

                {{-- Target IPS n IPK Semester Depan --}}
                <div x-cloak x-data="{ openTargetReports: false }" class="overflow-x-auto mb-2 mt-2">
                    <h2 class="text-xl font-bold text-[#013F4E]">D. TARGET SEMESTER DEPAN</h2>
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Rencana Nilai IPS dan IPK
                        Semester
                        Depan
                    </p>
                    <x-tabel :headers="['No', 'Semester', 'IPS', 'IPK', 'Status', 'Aksi']" :rows="$parsingNextReports" />
                    <button @click="openTargetReports = true"
                        class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                        Tambah
                    </button>

                    <x-modal title="Tambah data IPS dan IPK" show="openTargetReports">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('laporan.next-semester-reports.store', $laporan->laporan_id) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Semester</label>
                                <input type="text" name="semester"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Rencana IPS</label>
                                <input type="text" name="target-ips"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Rencana IPK</label>
                                <input type="text" name="target-ipk"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openTargetReports = false"
                                    class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                <button type="submit"
                                    class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                            </div>
                        </form>
                    </x-modal>
                </div>
                {{-- Target Academic Activities Semester Depan --}}
                <div x-cloak x-data="{ openTargetAcademic: false }" class="overflow-x-auto mb-2">
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Rencana Kegiatan Akademik
                        Semester
                        Depan
                    </p>
                    <x-tabel :headers="['No', 'Nama Kegiatan', 'Rencana/Strategi', 'Status', 'Aksi']" :rows="$parsingNextAcademicActivities" />
                    <button @click="openTargetAcademic = true"
                        class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                        Tambah
                    </button>

                    <x-modal title="Tambah Data Rencana Kegiatan Akademik" show="openTargetAcademic">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('laporan.next-smt-activities.store', $laporan->laporan_id) }}">
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

                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="openTargetAcademic = false"
                                    class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                                <button type="submit"
                                    class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                            </div>
                        </form>
                    </x-modal>
                </div>
                {{-- Achievements --}}
                <div x-cloak x-data="{ openTargetAchievement: false }" class="overflow-x-auto mb-2">
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Rencana Prestasi</p>
                    <x-tabel :headers="['No', 'Nama Prestasi', 'Tingkat', 'Raihan', 'Status', 'Aksi']" :rows="$parsingNextAchievements" />

                    <button @click="openTargetAchievement = true"
                        class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                        Tambah
                    </button>

                    <x-modal title="Tambah Data Rencana Prestasi" show="openTargetAchievement">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('laporan.next-smt-achievements.store', $laporan->laporan_id) }}">
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
                </div>
                {{-- Target Independen Activities --}}
                <div x-cloak x-data="{ openTargetIndependent: false }" class="overflow-x-auto mb-2">
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Rencana Kegiatan Mandiri</p>
                    <x-tabel :headers="['No', 'Nama Kegiatan', 'Rencana/Strategi', 'Keikutsertaan', 'Status', 'Aksi']" :rows="$parsingNextIndependentActivities" />

                    <button @click="openTargetIndependent = true"
                        class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                        Tambah
                    </button>

                    <x-modal title="Tambah Data Rencana Kegiatan Mandiri" show="openTargetIndependent">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('laporan.next-smt-independent.store', $laporan->laporan_id) }}">
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
                </div>
            </div>
        </div>
    </section>
</body>

</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <title>Pengisian Monev</title>
</head>

<body class="bg-[#F8F6F6]">
    <x-navbar-mhs mhsAvatar='{{ $dataMahasiswa->avatar }}' />

    @php
        $reports = [[1, 1, '4.00', '4.00', 'Tidak Ada', 'Lihat']];
        $academicActivities = [
            [
                1,
                'Perkuliahan',
                'Kuliah Reguler',
                'Anggota',
                'Kampus TSU',
                '8-09-2025',
                '08-09-2025',
                'Tidak Ada',
                'Lihat',
            ],
        ];
        $organizationActivities = [
            [
                1,
                'Perkuliahan',
                'Kuliah Reguler',
                'Anggota',
                'Perguruan Tinggi',
                'Kampus TSU',
                '8-09-2025',
                '08-09-2025',
                'Tidak Ada',
                'Lihat',
            ],
        ];
        $committeeActivities = [
            [
                1,
                'Perkuliahan',
                'Kuliah Reguler',
                'Anggota',
                'Perguruan Tinggi',
                'Kampus TSU',
                '8-09-2025',
                '08-09-2025',
                'Tidak Ada',
                'Lihat',
            ],
        ];
        $achievements = [
            [
                1,
                'Lorem',
                'Non-Pemerintah',
                'Individu',
                'Regional',
                'Juara 1',
                'Kampus TSU',
                '8-09-2025',
                '08-09-2025',
                'Tidak Ada',
                'Lihat',
            ],
        ];
        $independentActivities = [
            [1, 'Lorem', 'Lorem ipsum', 'Anggota', 'Kampus TSU', '8-09-2025', '08-09-2025', 'Tidak Ada', 'Lihat'],
        ];
        $targetReports = [[1, 2, '4.00', '4.00', 'Lihat']];
        $targetAcademicActivities = [[1, 'Perkuliahan', 'Kuliah Reguler', 'Lihat']];
        $targetAchievements = [[1, 'Lorem', 'Regional', 'Juara 1', 'Lihat']];
        $targetIndependentActivities = [[1, 'Lorem', 'Anggota', 'Kampus TSU', 'Lihat']];
    @endphp

    <section class="flex justify-center w-full h-auto">
        <div class="bg-[#fdfdfd] w-[1000px] h-auto p-6">
            <h2 class="text-xl font-bold mb-2">Pengisian Laporan Monev</h2>
            <div class="w-full h-[100px] bg-amber-100 mb-2"></div>

            {{-- Reports --}}
            <div x-cloak x-data="{ openReports: false }" class="overflow-x-auto mb-2 mt-5">
                <h2 class="text-xl font-bold text-[#013F4E]">A. KEGIATAN AKADEMIK</h2>
                <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Nilai IPS dan IPK Semester Ini</p>
                <x-tabel :headers="['No', 'Semester', 'IPS', 'IPK', 'Bukti', 'Aksi']" :rows="$reports" />
                {{-- Tambah btn --}}
                <button @click="openReports = true"
                    class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                    Tambah
                </button>
                {{-- Modal --}}
                <x-modal title="Tambah data IPS dan IPK" show="openReports">
                    <form method="POST" action="">
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
                            <label class="block text-sm font-medium">Bukti <span class="text-red-500">*</span></label>
                            <input type="file" name="bukti"
                                class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                        </div>
                        <!-- Actions -->
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
                    'Aksi',
                ]" :rows="$academicActivities" />
                {{-- Tambah btn --}}
                <button @click="openAcademic = true"
                    class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                    Tambah
                </button>
                {{-- Modal --}}
                <x-modal title="Tambah Data Kegiatan Akademik" show="openAcademic">
                    <form method="POST" action="">
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
                                <option value="Program Kreativitas Mahasiswa">Program Kreativitas Mahasiswa</option>
                                <option value="Sertifikasi Internasional Program Studi">Sertifikasi Internasional
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
                        <!-- Actions -->
                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" @click="openAcademic = false"
                                class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                            <button type="submit" class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                        </div>
                    </form>
                </x-modal>
            </div>

            {{-- Organization Activities --}}
            <div x-cloak x-data="{ openOrganization: false }" class="overflow-x-auto mb-2 mt-4">
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
                    'Aksi',
                ]" :rows="$organizationActivities" />
                {{-- Tambah btn --}}
                <button @click="openOrganization = true"
                    class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                    Tambah
                </button>
                {{-- Modal --}}
                <x-modal title="Tambah Data Kegiatan Organisasi" show="openOrganization">
                    <form method="POST" action="">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-sm font-medium">Nama UKM <span class="text-red-500">*</span></label>
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
                            <label class="block text-sm font-medium">Nama Kegiatan <span class="text-red-500">*</span></label>
                            <input type="text" name="nama-kegiatan"
                                class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium">Keikutsertaan <span class="text-red-500">*</span></label>
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
                            <label class="block text-sm font-medium">Bukti <span class="text-red-500">*</span></label>
                            <input type="file" name="bukti"
                                class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                        </div>
                        <!-- Actions -->
                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" @click="openOrganization = false"
                                class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                            <button type="submit" class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                        </div>
                    </form>
                </x-modal>
            </div>
            {{-- Committee Activities --}}
            <div x-cloak x-data="{ openCommittee: false }" class="overflow-x-auto mb-2">
                <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Kegiatan Kepanitiaan Atau Penugasan
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
                    'Aksi',
                ]" :rows="$committeeActivities" />
                {{-- Tambah btn --}}
                <button @click="openCommittee = true"
                    class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                    Tambah
                </button>
                {{-- Modal --}}
                <x-modal title="Tambah Data Kegiatan Penugasan dan Kepanitian" show="openCommittee">
                    <form method="POST" action="">
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
                        <!-- Actions -->
                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" @click="openCommittee = false"
                                class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                            <button type="submit" class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
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
                    'Aksi',
                ]" :rows="$achievements" />
                {{-- Tambah btn --}}
                <button @click="openAchievement = true"
                    class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                    Tambah
                </button>
                {{-- Model --}}
                <x-modal title="Tambah Data Prestasi" show="openAchievement">
                    <form method="POST" action="">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-sm font-medium">Nama Prestasi</label>
                            <input type="text" name="nama-prestasi"
                                class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium">Cakupan</label>
                            <input type="text" name="cakupan"
                                class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium">Kelompok/Individu</label>
                            <input type="text" name="kelompok-individu"
                                class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium">Raihan</label>
                            <input type="text" name="raihan"
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
                        <!-- Actions -->
                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" @click="openAchievement = false"
                                class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                            <button type="submit" class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                        </div>
                    </form>
                </x-modal>
            </div>
            {{-- Independen Activities --}}
            <div x-cloak x-data="{ openIndependent: false }" class="overflow-x-auto mb-2">
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
                    'Aksi',
                ]" :rows="$independentActivities" />
                {{-- Tambah btn --}}
                <button @click="openIndependent = true"
                    class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                    Tambah
                </button>
                {{-- Modal --}}
                <x-modal title="Tambah Data Kegiatan Mandiri" show="openIndependent">
                    <form method="POST" action="">
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
                        <!-- Actions -->
                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" @click="openIndependent = false"
                                class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                            <button type="submit" class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
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
                        placeholder="Tuliskan Faktor Pendukungmu Disini"></textarea>
                </div>
                <div>
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Faktor Penghambat</p>
                    <textarea name="faktor-pendukung" id=""
                        class="resize-none px-2 py-0.5 w-[450px] h-[200px] shadow-md border border-[#c0c0c0] focus:outline-none focus:ring-0"
                        placeholder="Tuliskan Faktor Penghambat Disini"></textarea>
                </div>
            </div>

            {{-- Target IPS n IPK Semester Depan --}}
            <div x-cloak x-data="{ openTargetReports: false }" class="overflow-x-auto mb-2 mt-2">
                <h2 class="text-xl font-bold text-[#013F4E]">D. TARGET SEMESTER DEPAN</h2>
                <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Rencana Nilai IPS dan IPK Semester Depan</p>
                <x-tabel :headers="['No', 'Semester', 'IPS', 'IPK', 'Bukti']" :rows="$targetReports" />
                {{-- Tambah btn --}}
                <button @click="openTargetReports = true"
                    class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                    Tambah
                </button>
                {{-- Modal --}}
                <x-modal title="Tambah data IPS dan IPK" show="openTargetReports">
                    <form method="POST" action="">
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
                        <!-- Actions -->
                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" @click="openTargetReports = false"
                                class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                            <button type="submit" class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                        </div>
                    </form>
                </x-modal>
            </div>
            {{-- Target Academic Activities Semester Depan --}}
            <div x-cloak x-data="{ openTargetAcademic: false }" class="overflow-x-auto mb-2">
                <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Rencana Kegiatan Akademik Semester Depan</p>
                <x-tabel :headers="['No', 'Nama Kegiatan', 'Rencana/Strategi', 'Aksi']" :rows="$targetAcademicActivities" />
                {{-- Tambah btn --}}
                <button @click="openTargetAcademic = true"
                    class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                    Tambah
                </button>
                {{-- Modal --}}
                <x-modal title="Tambah Data Rencana Kegiatan Akademik" show="openTargetAcademic">
                    <form method="POST" action="">
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
                        <!-- Actions -->
                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" @click="openTargetAcademic = false"
                                class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                            <button type="submit" class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                        </div>
                    </form>
                </x-modal>
            </div>
            {{-- Achievements --}}
            <div x-cloak x-data="{ openTargetAchievement: false }" class="overflow-x-auto mb-2">
                <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Rencana Prestasi</p>
                <x-tabel :headers="['No', 'Nama Prestasi', 'Tingkat', 'Raihan', 'Aksi']" :rows="$targetAchievements" />
                {{-- Tambah btn --}}
                <button @click="openTargetAchievement = true"
                    class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                    Tambah
                </button>
                {{-- Modal --}}
                <x-modal title="Tambah Data Rencana Prestasi" show="openTargetAchievement">
                    <form method="POST" action="">
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
                        <!-- Actions -->
                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" @click="openTargetAchievement = false"
                                class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                            <button type="submit" class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                        </div>
                    </form>
                </x-modal>
            </div>
            {{-- Target Independen Activities --}}
            <div x-cloak x-data="{ openTargetIndependent: false }" class="overflow-x-auto mb-2">
                <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Rencana Kegiatan Mandiri</p>
                <x-tabel :headers="['No', 'Nama Kegiatan', 'Rencana/Strategi', 'Keikutsertaan', 'Aksi']" :rows="$targetIndependentActivities" />
                {{-- Tambah btn --}}
                <button @click="openTargetIndependent = true"
                    class="border border-black mt-2 px-2 rounded-lg hover:bg-gray-100 transition cursor-pointer">
                    Tambah
                </button>
                {{-- Modal --}}
                <x-modal title="Tambah Data Rencana Kegiatan Mandiri" show="openTargetIndependent">
                    <form method="POST" action="">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-sm font-medium">Nama Kegiatan</label>
                            <input type="text" name="nama-prestasi"
                                class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium">Rencana/Strategi</label>
                            <input type="text" name="rencana-strategi"
                                class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium">Keikutsertaan</label>
                            <input type="text" name="partisipasi"
                                class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                        </div>
                        <!-- Actions -->
                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" @click="openTargetIndependent = false"
                                class="px-3 py-1 border rounded hover:bg-gray-100 transition cursor-pointer">Batal</button>
                            <button type="submit" class="px-3 py-1 bg-[#09697E] text-white rounded">Simpan</button>
                        </div>
                    </form>
                </x-modal>
            </div>
        </div>
    </section>
</body>

</html>

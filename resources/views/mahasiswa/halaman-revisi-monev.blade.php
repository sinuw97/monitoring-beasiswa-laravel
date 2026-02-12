@extends('mahasiswa.layout')

@section('title', 'Revisi Laporan Monev')

@section('content')
    <div class="bg-white w-full rounded-xl shadow-md p-6 border border-gray-100">
        <h2 class="text-xl font-bold ml-1 sm:ml-3 mb-2 text-[#013F4E]">Detail Laporan Monev</h2>
        {{-- Card --}}
        <div
            class="h-auto bg-[#fefefe] border-l-4 border-[#E8BE00] text-[#09697E] font-semibold px-3 py-3 rounded mb-3 shadow-md">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-[20px] h-[20px]" viewBox="0 0 24 24" id="user">
                    <path fill="#09697E"
                        d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1,1,0,0,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1A10,10,0,0,0,15.71,12.71ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z">
                    </path>
                </svg>
                <p>Nama : {{ $dataMahasiswa->name }}</p>
            </div>
            <div class="flex items-center gap-2">
                <svg viewBox="0 0 24 24" fill="none" class="w-[20px] h-[20px]" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M3 5C2.44772 5 2 5.44771 2 6V18C2 18.5523 2.44772 19 3 19H21C21.5523 19 22 18.5523 22 18V6C22 5.44772 21.5523 5 21 5H3ZM0 6C0 4.34315 1.34314 3 3 3H21C22.6569 3 24 4.34315 24 6V18C24 19.6569 22.6569 21 21 21H3C1.34315 21 0 19.6569 0 18V6ZM6 10.5C6 9.67157 6.67157 9 7.5 9C8.32843 9 9 9.67157 9 10.5C9 11.3284 8.32843 12 7.5 12C6.67157 12 6 11.3284 6 10.5ZM10.1756 12.7565C10.69 12.1472 11 11.3598 11 10.5C11 8.567 9.433 7 7.5 7C5.567 7 4 8.567 4 10.5C4 11.3598 4.31002 12.1472 4.82438 12.7565C3.68235 13.4994 3 14.7069 3 16C3 16.5523 3.44772 17 4 17C4.55228 17 5 16.5523 5 16C5 15.1145 5.80048 14 7.5 14C9.19952 14 10 15.1145 10 16C10 16.5523 10.4477 17 11 17C11.5523 17 12 16.5523 12 16C12 14.7069 11.3177 13.4994 10.1756 12.7565ZM13 8C12.4477 8 12 8.44772 12 9C12 9.55228 12.4477 10 13 10H19C19.5523 10 20 9.55228 20 9C20 8.44772 19.5523 8 19 8H13ZM14 12C13.4477 12 13 12.4477 13 13C13 13.5523 13.4477 14 14 14H18C18.5523 14 19 13.5523 19 13C19 12.4477 18.5523 12 18 12H14Z"
                            fill="#09697E"></path>
                    </g>
                </svg>
                <p>NIM : {{ $dataMahasiswa->nim }}</p>
            </div>
            <div class="flex items-center gap-2">
                <svg viewBox="0 0 24 24" version="1.1" class="w-[20px] h-[20px]" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <title></title>
                        <g fill="none" fill-rule="evenodd" id="页面-1" stroke="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="1">
                            <g id="导航图标" stroke="#09697E" stroke-width="1.5"
                                transform="translate(-28.000000, -272.000000)">
                                <g id="学术" transform="translate(28.000000, 272.000000)">
                                    <g id="编组" transform="translate(1.000000, 4.000000)">
                                        <polygon id="路径" points="0 2.75 11 0 22 2.75 11 5.5"></polygon>
                                        <path
                                            d="M4.95,4.4 L4.95,9.88383 C4.95,9.88383 7.7,11.55 11,11.55 C14.3,11.55 17.05,9.88383 17.05,9.88383 L17.05,4.4"
                                            id="路径"></path>
                                        <line id="路径" x1="1.65" x2="1.65" y1="3.3" y2="15.4">
                                        </line>
                                        <rect height="3.3" id="矩形" width="3.3" x="0" y="14.3"></rect>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
                <p>Semester {{ $laporan->semester }}</p>
            </div>
            <div class="flex items-center gap-2">
                <svg viewBox="0 0 20 20" version="1.1" class="w-[20px] h-[20px]" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <title>time / 27 - time, calendar, time, date, event, planner, shedule, task icon</title>
                        <g id="Free-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                            stroke-linecap="round" stroke-linejoin="round">
                            <g transform="translate(-303.000000, -748.000000)" id="Group" stroke="#09697E"
                                stroke-width="2">
                                <g transform="translate(301.000000, 746.000000)" id="Shape">
                                    <circle cx="15.5" cy="15.5" r="5.5"> </circle>
                                    <polyline points="15.5 13.3440934 15.5 15.5 17 17"> </polyline>
                                    <line x1="17" y1="3" x2="17" y2="5"> </line>
                                    <line x1="7" y1="3" x2="7" y2="5"> </line>
                                    <path
                                        d="M8.03064542,21 C7.42550126,21 6.51778501,21 5.30749668,21 C4.50512981,21 4.2141722,20.9218311 3.92083887,20.7750461 C3.62750553,20.6282612 3.39729582,20.4128603 3.24041943,20.1383964 C3.08354305,19.8639324 3,19.5916914 3,18.8409388 L3,7.15906122 C3,6.4083086 3.08354305,6.13606756 3.24041943,5.86160362 C3.39729582,5.58713968 3.62750553,5.37173878 3.92083887,5.22495386 C4.2141722,5.07816894 4.50512981,5 5.30749668,5 L18.6925033,5 C19.4948702,5 19.7858278,5.07816894 20.0791611,5.22495386 C20.3724945,5.37173878 20.6027042,5.58713968 20.7595806,5.86160362 C20.9164569,6.13606756 21,7.24671889 21,7.99747152">
                                    </path>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
                <p>Periode :
                    {{ $laporan->periodeSemester?->tahun_akademik }}
                    {{ $laporan->periodeSemester?->semester }}
                </p>
            </div>
            <div class="flex items-center gap-2">
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
                <p>Dibuat : {{ $laporan->created_at->translatedFormat('d F Y') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <svg fill="#09697E" class="w-[20px] h-[20px]" version="1.1" id="Icon"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"
                    enable-background="new 0 0 24 24" xml:space="preserve">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M12,0C5.38,0,0,5.38,0,12s5.38,12,12,12s12-5.38,12-12S18.62,0,12,0z M12,22C6.49,22,2,17.51,2,12S6.49,2,12,2 s10,4.49,10,10S17.51,22,12,22z M10.5,10h3v8h-3V10z M10.5,5h3v3h-3V5z">
                        </path>
                    </g>
                </svg>
                <p>Status : {{ $laporan->status }}</p>
            </div>
        </div>
        {{-- Information --}}
        <div class="bg-[#EAF6F8] border-l-4 border-[#1D7D94] rounded-md px-4 py-3 mb-4">
            <h2 class="text-[#0F3F4A] font-semibold">Laporan ini dikembalikan karena ada beberapa data kegiatan
                yang harus direvisi dari dosen!</h2>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-600 text-[#013F4E] w-full px-3 py-3 rounded mb-3">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="bg-red-200 border-l-4 border-red-600 text-red-700 w-full px-3 py-3 rounded mb-3">
                {{ session('error') }}
            </div>
        @endif

        <div class="space-y-6">
            {{-- Reports --}}
            <div x-cloak x-data="{ openReports: false, openEditReports: false, editDataReports: {} }" class="mb-3 mt-5 pr-3 cursor-default"
                x-on:edit-reports.window="editDataReports = $event.detail; openEditReports = true">
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">A. Kegiatan Akademik (IPS &
                    IPK Semester ini)</h3>

                <div class="overflow-x-auto">
                    <x-tabel :headers="['No', 'Semester', 'IPS', 'IPK', 'Bukti', 'Komentar', 'Status']" :columns="['semester', 'ips', 'ipk', 'bukti', 'komentar', 'status']" :rows="$parsingAcademicReports" idKey="id" editEvent="edit-reports"
                        deleteRoute="laporan.academic-reports.delete" :status="$laporan->status" style="riwayat" />
                </div>

                {{-- Modal --}}
                @if ($laporan->status === 'Dikembalikan')
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
                                    class="px-3 py-1 bg-[#52AEFF] hover:bg-[#8AC8FF] rounded transition cursor-pointer">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-3 py-1 bg-[#21C40F] hover:bg-[#0DD603] text-white rounded cursor-pointer">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </x-modal>
                @endif
            </div>

            {{-- Academic Activities --}}
            <div x-cloak x-data="{ openAcademic: false, openEditAcademic: false, editDataAcademy: {} }" class="mb-2 pr-3 cursor-default"
                x-on:edit-academic.window="editDataAcademy = $event.detail; openEditAcademic = true">
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">Kegiatan Akademik Lainnya
                </h3>

                {{-- Tabel --}}
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
                        'Point',
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
                    ]" :rows="$parsingAcademicActivities" idKey="id"
                        editEvent="edit-academic" deleteRoute="laporan.academic-activities.delete" :status="$laporan->status"
                        style="riwayat" />
                </div>

                {{-- Modal --}}
                @if ($laporan->status === 'Dikembalikan')
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
                                    class="px-3 py-1 bg-[#52AEFF] hover:bg-[#8AC8FF] rounded transition cursor-pointer">Batal</button>
                                <button type="submit"
                                    class="px-3 py-1 bg-[#21C40F] hover:bg-[#0DD603] transition text-white rounded cursor-pointer">Simpan</button>
                            </div>
                        </form>
                    </x-modal>
                @endif
            </div>

            {{-- Organization Activities --}}
            <div x-cloak x-data="{ openOrganization: false, openEditOrg: false, editDataOrg: {} }" class="mb-2 pr-3 cursor-default"
                x-on:edit-org.window="editDataOrg = $event.detail; openEditOrg = true">
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">B. Kegiatan Non-Akademik
                    (Organisasi)</h3>

                {{-- tabel --}}
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
                        'Point',
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
                    ]" :rows="$parsingOrganizationActivities" idKey="id" editEvent="edit-org"
                        deleteRoute="laporan.org-activities.delete" :status="$laporan->status" style="riwayat" />
                </div>

                {{-- Modal --}}
                @if ($laporan->status === 'Dikembalikan')
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
                                    class="px-3 py-1 bg-[#52AEFF] hover:bg-[#8AC8FF] rounded transition cursor-pointer">Batal</button>
                                <button type="submit"
                                    class="px-3 py-1 bg-[#21C40F] hover:bg-[#0DD603] transition text-white rounded cursor-pointer">Simpan</button>
                            </div>
                        </form>
                    </x-modal>
                @endif
            </div>

            {{-- Committee Activities --}}
            <div x-cloak x-data="{ openCommittee: false, openEditCommittee: false, editDataCommittee: {} }" class="mb-2 pr-3 cursor-default"
                x-on:edit-committee.window="editDataCommittee = $event.detail; openEditCommittee = true">
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">Kegiatan Kepanitiaan</h3>

                {{-- Tabel --}}
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
                        'Point',
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
                    ]" :rows="$parsingCommitteeActivities" idKey="id"
                        editEvent="edit-committee" deleteRoute="laporan.committee-activities.hapus" :status="$laporan->status"
                        style="riwayat" />
                </div>

                {{-- Modal --}}
                @if ($laporan->status === 'Dikembalikan')
                    {{-- Modal Edit --}}
                    <x-modal title="Tambah Data Kegiatan Penugasan dan Kepanitian" show="openEditCommittee">
                        <form method="POST" enctype="multipart/form-data"
                            x-bind:action="'{{ route('laporan.committee-activities.update', ':id') }}'.replace(':id',
                                editDataCommittee.id)">
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
                                    class="px-3 py-1 bg-[#52AEFF] hover:bg-[#8AC8FF] rounded transition cursor-pointer">Batal</button>
                                <button type="submit"
                                    class="px-3 py-1 bg-[#21C40F] hover:bg-[#0DD603] transition text-white rounded cursor-pointer">Simpan</button>
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
            </div>

            {{-- Achievements --}}
            <div x-cloak x-data="{ openAchievement: false, openEditAchievement: false, editDataAchievement: {} }" class="mb-2 pr-3 cursor-default"
                x-on:edit-achievement.window="editDataAchievement = $event.detail; openEditAchievement = true">
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">Prestasi</h3>

                {{-- Tabel --}}
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
                        'Point',
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
                    ]" :rows="$parsingAchievements" idKey="id"
                        editEvent="edit-achievement" deleteRoute="laporan.achievements.hapus" :status="$laporan->status"
                        style="riwayat" />
                </div>

                {{-- Modal --}}
                @if ($laporan->status === 'Dikembalikan')
                    {{-- Modal Edit --}}
                    <x-modal title="Edit Data Prestasi" show="openEditAchievement">
                        <form method="POST" enctype="multipart/form-data"
                            x-bind:action="'{{ route('laporan.achievements.update', ':id') }}'.replace(':id', editDataAchievement
                                .id)">
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
                                    class="px-3 py-1 bg-[#52AEFF] hover:bg-[#8AC8FF] rounded transition cursor-pointer">Batal</button>
                                <button type="submit"
                                    class="px-3 py-1 bg-[#21C40F] hover:bg-[#0DD603] transition text-white rounded cursor-pointer">Simpan</button>
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
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">Kegiatan Mandiri</h3>

                {{-- Tabel --}}
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
                        'Point',
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
                    ]" :rows="$parsingIndependentActivities" idKey="id"
                        editEvent="edit-independent" deleteRoute="laporan.independent-activities.hapus" :status="$laporan->status"
                        style="riwayat" />
                </div>

                {{-- Modal --}}
                @if ($laporan->status === 'Dikembalikan')
                    {{-- Modal Edit --}}
                    <x-modal title="Edit Data Kegiatan Mandiri" show="openEditIndependent">
                        <form method="POST" enctype="multipart/form-data"
                            x-bind:action="'{{ route('laporan.independent-activities.update', ':id') }}'.replace(':id',
                                editDataIndependent.id)">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Kegiatan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama-kegiatan" x-model="editDataIndependent['activity-name']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tipe Kegiatan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tipe-kegiatan" x-model="editDataIndependent['activity-type']"
                                    class="w-full border rounded px-2 py-1 focus:outline-none focus:ring-0">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Keikutsertaan
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="keikutsertaan" x-model="editDataIndependent['participation']"
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
                                    class="px-3 py-1 bg-[#52AEFF] hover:bg-[#8AC8FF] rounded transition cursor-pointer">Batal</button>
                                <button type="submit"
                                    class="px-3 py-1 bg-[#21C40F] hover:bg-[#0DD603] transition text-white rounded cursor-pointer">Simpan</button>
                            </div>
                        </form>
                    </x-modal>
                @endif
            </div>

            {{-- Evaluations --}}
            <div x-cloak x-data="{ openEvaluation: false, openEditEvaluation: false, editDataEvaluation: {} }" class="pl-3 mb-2 mt-4 cursor-default">
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">C. Evaluasi Diri</h3>
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Faktor Pendukung</p>
                        <textarea readonly
                            class="resize-none px-2 py-1 w-full sm:w-[450px] h-[200px] cursor-default shadow-md border border-[#c0c0c0] focus:outline-none">{{ $parsingEvaluations->support_factors ?? '-' }}</textarea>
                    </div>
                    <div class="flex-1">
                        <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5">Faktor Penghambat</p>
                        <textarea readonly
                            class="resize-none px-2 py-1 w-full sm:w-[450px] h-[200px] cursor-default shadow-md border border-[#c0c0c0] focus:outline-none">{{ $parsingEvaluations->barrier_factors ?? '-' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Target Next SMT --}}
            <div x-cloak x-data="{ openTargetRep: false, openEditTargetRep: false, editDataTargetRep: {} }" class="mb-2 mt-2 pr-3 cursor-default"
                x-on:edit-target-rep.window="editDataTargetRep = $event.detail; openEditTargetRep = true">
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">D. Rencana Semester Depan
                </h3>

                <div class="overflow-x-auto">
                    <x-tabel :headers="['No', 'Semester', 'Target IPS', 'Target IPK', 'Status']" :columns="['semester', 'target-ips', 'target-ipk', 'status']" :rows="$parsingNextReports" idKey="id"
                        editEvent="edit-target-rep" deleteRoute="laporan.next-semester-reports.hapus" :status="$laporan->status"
                        style="riwayat" />
                </div>
            </div>

            {{-- Target Keg Akademik --}}
            <div x-cloak x-data="{ openTargetAcademic: false, openEditTargetAcademic: false, editDataTargetAcademic: {} }" class="mb-2 pr-3 cursor-default"
                x-on:edit-target-academic.window="editDataTargetAcademic = $event.detail; openEditTargetAcademic = true">
                <h4 class="font-semibold text-gray-700 mb-1">Rencana Kegiatan Akademik</h4>

                <div class="overflow-x-auto">
                    <x-tabel :headers="['No', 'Nama Kegiatan', 'Rencana/Strategi', 'Status']" :columns="['activity-name', 'strategy', 'status']" :rows="$parsingNextAcademicActivities" idKey="id"
                        editEvent="edit-target-academic" deleteRoute="laporan.next-smt-activities.hapus"
                        :status="$laporan->status" style="riwayat" />
                </div>
            </div>

            {{-- Target Achievements --}}
            <div x-cloak x-data="{ openTargetAchievement: false, openEditTargetAchievement: false, editDatatargetAchievement: {} }" class="mb-2 pr-3 cursor-default"
                x-on:edit-target-achievement="editDatatargetAchievement = $event.detail; openEditTargetAchievement = true">
                <h4 class="font-semibold text-gray-700 mb-1">Rencana Prestasi</h4>

                <div class="overflow-x-auto">
                    <x-tabel :headers="['No', 'Nama Prestasi', 'Tingkat', 'Raihan', 'Status']" :columns="['achievements-name', 'level', 'award', 'status']" :rows="$parsingNextAchievements" idKey="id"
                        editEvent="edit-target-achievement" deleteRoute="laporan.next-smt-achievements.hapus"
                        :status="$laporan->status" style="riwayat" />
                </div>
            </div>

            {{-- Target Independent --}}
            <div x-cloak x-data="{ openTargetIndependent: false, openEditTargetIndependent: false, editDataTargetIndependent: {} }" class="mb-2 pr-3 cursor-default"
                x-on:edit-target-independent="editDataTargetIndependent = $event.detail; openEditTargetIndependent = true">
                <p class="text-[#013F4E] text-[14pt] font-semibold ml-1 sm:ml-3 mb-0.5">Rencana Kegiatan Mandiri
                </p>

                <div class="overflow-x-auto">
                    <x-tabel :headers="['No', 'Nama Kegiatan', 'Rencana/Strategi', 'Keikutsertaan', 'Status']" :columns="['activity-name', 'strategy', 'participation', 'status']" :rows="$parsingNextIndependentActivities" idKey="id"
                        editEvent="edit-target-independent" deleteRoute="laporan.next-smt-independent.hapus"
                        :status="$laporan->status" style="riwayat" />
                </div>
            </div>

            {{-- Keuangan --}}
            <div x-cloak x-data="{ openKeuangan: false, openEditKeuangan: false, editDataKeuangan: {} }" class="mb-2 cursor-default"
                x-on:edit-keuangan="editDataKeuangan = $event.detail; openEditKeuangan = true">
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">E. Laporan Keuangan</h3>

                {{-- Ringkasan Total Keuangan --}}
                <div class="mb-3">
                    <div
                        class="flex items-center justify-between bg-white border-l-4 border-[#f9d223] rounded-lg shadow-sm px-4 py-3">
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

                @if ($laporan->status === 'Dikembalikan')
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
            <div x-cloak x-data="{ openKesanPesan: false, openEditKesanPesan: false, editDataKesanPesan: {} }" class="mb-2 cursor-default"
                x-on:edit-pesan-kesan="editDataKesanPesan = $event.detail; openEditKesanPesan = true">
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">F. Kesan dan Pesan Mahasiswa</h3>

                <div class="overflow-x-auto w-full">
                    <x-tabel :headers="['No', 'Kesan', 'Pesan', 'Status']" :columns="['kesan', 'pesan', 'status']" :rows="$parsingKesanPesan" idKey="id"
                        editEvent="edit-pesan-kesan" deleteRoute="laporan.kesan-pesan.hapus" :status="$laporan->status"
                        style="riwayat" />
                </div>

                @if ($laporan->status === 'Dikembalikan')
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
        </div>

        {{-- Button Aksi --}}
        <div x-cloak x-data="{ openModalKonfirmasi: false }" class="mt-4 flex gap-2">
            <button type="button"
                class="button bg-[#E8BE00] hover:bg-[#d4ae06] text-black px-2 py-1 rounded-md cursor-pointer">
                <a href="{{ route('mahasiswa.dashboard') }}">Kembali</a>
            </button>
            <button @click="openModalKonfirmasi = true"
                class="button bg-[#3FAA54] hover:bg-[#48cc62] px-2 py-1 rounded-md cursor-pointer text-white">
                Ajukan
            </button>
            {{-- Modal Konfirmasi --}}
            <x-modal title="Konfirmasi Pengajuan Revisi Laporan" show="openModalKonfirmasi">
                <h1 class="text-center font-semibold">Apakah Anda yakin ingin mengirim kembali revisi laporan?</h1>
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
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                            class="px-3 py-1 bg-[#3FAA54] hover:bg-[#48cc62] text-[#fefefe] rounded transition cursor-pointer">
                            Konfirmasi
                        </button>
                    </form>
                </div>
            </x-modal>
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

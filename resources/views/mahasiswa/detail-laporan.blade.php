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

        #nprogress .bar {
            background: #09697E;
            height: 5px;
        }

        #nprogress .peg {
            box-shadow: 0 0 15px #09697E, 0 0 9px #09697E;
        }
    </style>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://unpkg.com/nprogress/nprogress.css">
    <title>Detail Laporan Monev - Monitoring Beasiswa</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>

<body class="bg-[#F8F6F6] min-h-screen">
    {{-- Navbar --}}
    <x-navbar-mhs mhsAvatar='{{ $dataMahasiswa->avatar }}' />

    <section class="flex justify-center w-full h-auto px-2 sm:px-4">
        <div class="bg-[#fdfdfd] w-full max-w-screen-xl h-auto p-4 sm:p-6 mt-4 rounded-lg shadow overflow-hidden">
            <h2 class="text-xl font-bold ml-1 sm:ml-3 mb-2 text-[#013F4E]">Detail Laporan Monev</h2>
            <div
                class="h-auto bg-[#fefefe] border-l-4 border-[#E8BE00] text-[#09697E] font-semibold px-3 py-3 rounded mb-3 shadow-md">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-[20px] h-[20px]" viewBox="0 0 24 24"
                        id="user">
                        <path fill="#09697E"
                            d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1,1,0,0,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1A10,10,0,0,0,15.71,12.71ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z">
                        </path>
                    </svg>
                    <p>Nama : {{ $dataMahasiswa->name }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" class="w-[20px] h-[20px]"
                        xmlns="http://www.w3.org/2000/svg">
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
                                            <line id="路径" x1="1.65" x2="1.65" y1="3.3"
                                                y2="15.4"></line>
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
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
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
                    <h2 class="text-xl font-bold text-[#013F4E] ml-1 sm:ml-3">A. KEGIATAN AKADEMIK</h2>
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5 ml-1 sm:ml-3">Nilai IPS dan IPK Semester
                        Ini</p>

                    <div class="overflow-x-auto">
                        <x-tabel :headers="['No', 'Semester', 'IPS', 'IPK', 'Bukti', 'Komentar', 'Status']" :columns="['semester', 'ips', 'ipk', 'bukti', 'komentar', 'status']" :rows="$parsingAcademicReports" idKey="id"
                            editEvent="edit-reports" deleteRoute="laporan.academic-reports.delete" :status="$laporan->status"
                            style="riwayat" />
                    </div>
                </div>

                {{-- Academic Activities --}}
                <div x-cloak x-data="{ openAcademic: false, openEditAcademic: false, editDataAcademy: {} }" class="mb-2 pr-3 cursor-default"
                    x-on:edit-academic.window="editDataAcademy = $event.detail; openEditAcademic = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5 ml-1 sm:ml-3">Kegiatan Akademik</p>

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
                            editEvent="edit-academic" deleteRoute="laporan.academic-activities.delete"
                            :status="$laporan->status" style="riwayat" />
                    </div>
                </div>

                {{-- Organization Activities --}}
                <div x-cloak x-data="{ openOrganization: false, openEditOrg: false, editDataOrg: {} }" class="mb-2 pr-3 cursor-default"
                    x-on:edit-org.window="editDataOrg = $event.detail; openEditOrg = true">
                    <h2 class="text-xl font-bold text-[#013F4E] ml-1 sm:ml-3 mt-4">B. KEGIATAN NON-AKADEMIK</h2>
                    <p class="text-[#013F4E] text-[14pt] font-semibold mb-0.5 ml-1 sm:ml-3">Kegiatan Organisasi
                        Mahasiswa</p>

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
                        ]" :rows="$parsingOrganizationActivities" idKey="id"
                            editEvent="edit-org" deleteRoute="laporan.org-activities.delete" :status="$laporan->status"
                            style="riwayat" />
                    </div>
                </div>

                {{-- Committee Activities --}}
                <div x-cloak x-data="{ openCommittee: false, openEditCommittee: false, editDataCommittee: {} }" class="mb-2 pr-3 cursor-default"
                    x-on:edit-committee.window="editDataCommittee = $event.detail; openEditCommittee = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold ml-1 sm:ml-3 mb-0.5">Kegiatan Kepanitiaan Atau
                        Penugasan</p>

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
                            editEvent="edit-committee" deleteRoute="laporan.committee-activities.hapus"
                            :status="$laporan->status" style="riwayat" />
                    </div>
                </div>

                {{-- Achievements --}}
                <div x-cloak x-data="{ openAchievement: false, openEditAchievement: false, editDataAchievement: {} }" class="mb-2 pr-3 cursor-default"
                    x-on:edit-achievement.window="editDataAchievement = $event.detail; openEditAchievement = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold ml-1 sm:ml-3 mb-0.5">Prestasi Mahasiswa</p>

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
                </div>

                {{-- Independent Activities --}}
                <div x-cloak x-data="{ openIndependent: false, openEditIndependent: false, editDataIndependent: {} }" class="mb-2 pr-3 cursor-default"
                    x-on:edit-independent="editDataIndependent = $event.detail; openEditIndependent = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold ml-1 sm:ml-3 mb-0.5">Kegiatan Mandiri Mahasiswa
                        Selama Satu Semester</p>

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
                            editEvent="edit-independent" deleteRoute="laporan.independent-activities.hapus"
                            :status="$laporan->status" style="riwayat" />
                    </div>
                </div>

                {{-- Evaluations --}}
                <div x-cloak x-data="{ openEvaluation: false, openEditEvaluation: false, editDataEvaluation: {} }" class="pl-3 mb-2 mt-4 cursor-default">
                    <h2 class="text-xl font-bold text-[#013F4E]">C. EVALUASI</h2>
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
                    <h2 class="text-xl font-bold text-[#013F4E] mt-4 ml-1 sm:ml-3">D. TARGET SEMESTER DEPAN</h2>
                    <p class="text-[#013F4E] text-[14pt] font-semibold ml-1 sm:ml-3 mb-0.5">Rencana Nilai IPS dan IPK
                        Semester Depan</p>

                    <div class="overflow-x-auto">
                        <x-tabel :headers="['No', 'Semester', 'Target IPS', 'Target IPK', 'Status']" :columns="['semester', 'target-ips', 'target-ipk', 'status']" :rows="$parsingNextReports" idKey="id"
                            editEvent="edit-target-rep" deleteRoute="laporan.next-semester-reports.hapus"
                            :status="$laporan->status" style="riwayat" />
                    </div>
                </div>

                {{-- Target Keg Akademik --}}
                <div x-cloak x-data="{ openTargetAcademic: false, openEditTargetAcademic: false, editDataTargetAcademic: {} }" class="mb-2 pr-3 cursor-default"
                    x-on:edit-target-academic.window="editDataTargetAcademic = $event.detail; openEditTargetAcademic = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold ml-1 sm:ml-3 mb-0.5">Rencana Kegiatan Akademik
                        Semester Depan</p>

                    <div class="overflow-x-auto">
                        <x-tabel :headers="['No', 'Nama Kegiatan', 'Rencana/Strategi', 'Status']" :columns="['activity-name', 'strategy', 'status']" :rows="$parsingNextAcademicActivities" idKey="id"
                            editEvent="edit-target-academic" deleteRoute="laporan.next-smt-activities.hapus"
                            :status="$laporan->status" style="riwayat" />
                    </div>
                </div>

                {{-- Target Achievements --}}
                <div x-cloak x-data="{ openTargetAchievement: false, openEditTargetAchievement: false, editDatatargetAchievement: {} }" class="mb-2 pr-3 cursor-default"
                    x-on:edit-target-achievement="editDatatargetAchievement = $event.detail; openEditTargetAchievement = true">
                    <p class="text-[#013F4E] text-[14pt] font-semibold ml-1 sm:ml-3 mb-0.5">Rencana Prestasi</p>

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
            </div>

            {{-- Tombol Kembali --}}
            <div class="mt-6 ml-3 flex justify-start px-2 sm:px-0">
                <a href="{{ route('mahasiswa.dashboard') }}"
                    class="bg-[#E8BE00] hover:hover:bg-[#fad11b] text-black font-semibold px-3 py-1 rounded-md transition text-sm sm:text-base">
                    Kembali
                </a>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/nprogress/nprogress.js"></script>

    <script>
        // load / submit form
        document.addEventListener('DOMContentLoaded', () => {
            NProgress.start()
        });

        // selesai load
        window.addEventListener('load', () => {
            NProgress.done()
        });

        // submit form
        document.addEventListener('submit', function() {
            NProgress.start()
        });
    </script>
</body>

</html>

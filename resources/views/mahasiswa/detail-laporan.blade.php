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
    <title>Riwayat Laporan Monev</title>
</head>

<body class="bg-[#F8F6F6] min-h-screen">
    {{-- Navbar --}}
    <x-navbar-mhs mhsAvatar='{{ $dataMahasiswa->avatar }}' />

    <section class="flex justify-center w-full h-auto px-2 sm:px-4">
        <div class="bg-[#fdfdfd] w-full max-w-screen-xl h-auto p-4 sm:p-6 mt-4 rounded-lg shadow overflow-hidden">
            <h2 class="text-xl font-bold ml-1 sm:ml-3 mb-2 text-[#013F4E]">Detail Laporan Monev</h2>
            <div class="h-auto bg-[#abdaff] border-l-4 border-[#1385DC] text-[#013F4E] mx-1 sm:mx-3 px-3 py-3 rounded mb-3 break-words text-sm sm:text-base">
                <p>Nama : {{ $dataMahasiswa->name }}</p>
                <p>NIM : {{ $dataMahasiswa->nim }}</p>
                <p>Periode : {{ $laporan->periodeSemester?->tahun_akademik }} {{ $laporan->periodeSemester?->semester }}
                </p>
                <p>Dibuat : {{ $laporan->created_at->translatedFormat('d F Y') }}</p>
                <p>Status : {{ $laporan->status }}</p>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-600 text-[#013F4E] w-full px-3 py-3 rounded mb-3">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="bg-red-200 border-l-4 border-red-600 text-red-700 w-full px-3 py-3 rounded mb-3">
                    {{ session('fails') }}
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
                            editEvent="edit-academic" deleteRoute="laporan.academic-activities.delete" :status="$laporan->status"
                            style="riwayat" />
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
            <div class="mt-6 flex justify-end px-2 sm:px-0">
                <a href="{{ route('mahasiswa.dashboard') }}"
                    class="bg-[#E8BE00] hover:bg-[#d0aa00] text-black font-semibold px-4 py-2 rounded-md transition text-sm sm:text-base">
                    Kembali
                </a>
            </div>
        </div>
    </section>
</body>

</html>
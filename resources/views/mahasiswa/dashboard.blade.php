<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Dashboard Mahasiswa</title>
</head>

<body class="bg-[#F8F6F6]">
    {{-- Navbar --}}
    <x-navbar-mhs mhsName='{{ $dataMahasiswa->name }}' mhsAvatar='{{ $dataMahasiswa->avatar }}' />

    <div class="flex">
        {{-- Sidebar --}}
        <aside class="w-[20%] h-screen bg-[#FEFEFE] flex flex-col sticky top-0">
            <div class="mx-6 my-10">
                <div class="flex flex-col justify-center gap-3 items-center pb-10 border-[#909090] border-b">
                    <img src="{{ $dataMahasiswa->avatar }}" alt="avatar-mhs" class="w-[50px] h-[5 0px] rounded-[50px]">
                    <h1>{{ $dataMahasiswa->name }}</h1>
                </div>
                <div class="flex mt-2 items-center gap-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="award-alt"
                        class="w-[15px] h-[15px]">
                        <path fill="#09697E"
                            d="M12,1A7,7,0,0,0,7,12.89V22a1,1,0,0,0,1.45.89L12,21.12l3.55,1.77A1,1,0,0,0,16,23a1,1,0,0,0,.53-.15A1,1,0,0,0,17,22V12.89A7,7,0,0,0,12,1Zm3,19.38-2.55-1.27a1,1,0,0,0-.9,0L9,20.38V14.32a7,7,0,0,0,2,.6V16a1,1,0,0,0,2,0V14.92a7,7,0,0,0,2-.6ZM12,13a5,5,0,1,1,5-5A5,5,0,0,1,12,13Z">
                        </path>
                    </svg>
                    <p class="mr-2">NIM</p>
                    <span>: {{ $dataMahasiswa->nim }}</span>
                </div>
                <div class="flex border-[#909090] border-b pb-2 items-center gap-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" id="calendar-alt"
                        class="w-[15px] h-[15px]">
                        <path fill="#09697E"
                            d="M12,19a1,1,0,1,0-1-1A1,1,0,0,0,12,19Zm5,0a1,1,0,1,0-1-1A1,1,0,0,0,17,19Zm0-4a1,1,0,1,0-1-1A1,1,0,0,0,17,15Zm-5,0a1,1,0,1,0-1-1A1,1,0,0,0,12,15ZM19,3H18V2a1,1,0,0,0-2,0V3H8V2A1,1,0,0,0,6,2V3H5A3,3,0,0,0,2,6V20a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V6A3,3,0,0,0,19,3Zm1,17a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V11H20ZM20,9H4V6A1,1,0,0,1,5,5H6V6A1,1,0,0,0,8,6V5h8V6a1,1,0,0,0,2,0V5h1a1,1,0,0,1,1,1ZM7,15a1,1,0,1,0-1-1A1,1,0,0,0,7,15Zm0,4a1,1,0,1,0-1-1A1,1,0,0,0,7,19Z">
                        </path>
                    </svg>
                    <p class="mr-2">Angkatan</p>
                    <span>: {{ $dataMahasiswa->detailMahasiswa->angkatan }}</span>
                </div>

                <div class="flex mt-2 items-center gap-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="book-open"
                        class="w-[15px] h-[15px]">
                        <path fill="#09697E"
                            d="M21.17,2.06A13.1,13.1,0,0,0,19,1.87a12.94,12.94,0,0,0-7,2.05,12.94,12.94,0,0,0-7-2,13.1,13.1,0,0,0-2.17.19,1,1,0,0,0-.83,1v12a1,1,0,0,0,1.17,1,10.9,10.9,0,0,1,8.25,1.91l.12.07.11,0a.91.91,0,0,0,.7,0l.11,0,.12-.07A10.9,10.9,0,0,1,20.83,16a1,1,0,0,0,1.17-1v-12A1,1,0,0,0,21.17,2.06ZM11,15.35a12.87,12.87,0,0,0-6-1.48c-.33,0-.66,0-1,0v-10a8.69,8.69,0,0,1,1,0,10.86,10.86,0,0,1,6,1.8Zm9-1.44c-.34,0-.67,0-1,0a12.87,12.87,0,0,0-6,1.48V5.67a10.86,10.86,0,0,1,6-1.8,8.69,8.69,0,0,1,1,0Zm1.17,4.15A13.1,13.1,0,0,0,19,17.87a12.94,12.94,0,0,0-7,2.05,12.94,12.94,0,0,0-7-2.05,13.1,13.1,0,0,0-2.17.19A1,1,0,0,0,2,19.21,1,1,0,0,0,3.17,20a10.9,10.9,0,0,1,8.25,1.91,1,1,0,0,0,1.16,0A10.9,10.9,0,0,1,20.83,20,1,1,0,0,0,22,19.21,1,1,0,0,0,21.17,18.06Z">
                        </path>
                    </svg>
                    <p class="mr-2">Prodi</p>
                    <span>: {{ $dataMahasiswa->detailMahasiswa->prodi }}</span>
                </div>
                <div class="flex items-center gap-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="users-alt"
                        class="w-[15px] h-[15px]">
                        <path fill="#09697E"
                            d="M12.3,12.22A4.92,4.92,0,0,0,14,8.5a5,5,0,0,0-10,0,4.92,4.92,0,0,0,1.7,3.72A8,8,0,0,0,1,19.5a1,1,0,0,0,2,0,6,6,0,0,1,12,0,1,1,0,0,0,2,0A8,8,0,0,0,12.3,12.22ZM9,11.5a3,3,0,1,1,3-3A3,3,0,0,1,9,11.5Zm9.74.32A5,5,0,0,0,15,3.5a1,1,0,0,0,0,2,3,3,0,0,1,3,3,3,3,0,0,1-1.5,2.59,1,1,0,0,0-.5.84,1,1,0,0,0,.45.86l.39.26.13.07a7,7,0,0,1,4,6.38,1,1,0,0,0,2,0A9,9,0,0,0,18.74,11.82Z">
                        </path>
                    </svg>
                    <p class="mr-2">Kelas</p>
                    <span>: {{ $dataMahasiswa->detailMahasiswa->kelas }}</span>
                </div>
                <div class="flex items-center gap-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="medal"
                        class="w-[15px] h-[15px]">
                        <path fill="#09697E"
                            d="M21.38,5.76a1,1,0,0,0-.47-.61l-5.2-3a1,1,0,0,0-1.37.36L12,6.57,9.66,2.51a1,1,0,0,0-1.37-.36l-5.2,3a1,1,0,0,0-.47.61,1,1,0,0,0,.1.75l4,6.83A5.91,5.91,0,0,0,6,16a6,6,0,1,0,11.34-2.72l3.9-6.76A1,1,0,0,0,21.38,5.76ZM5,6.38l3.46-2L11.68,10A5.94,5.94,0,0,0,8,11.58ZM12,20a4,4,0,0,1-4-4,4,4,0,0,1,4-4,4,4,0,1,1,0,8Zm4-8.45a5.9,5.9,0,0,0-1.86-1.15L13.16,8.57l2.42-4.19,3.46,2Z">
                        </path>
                    </svg>
                    <p class="mr-2">Beasiswa</p>
                    <span>: {{ $dataMahasiswa->detailMahasiswa->jenis_beasiswa }}</span>
                </div>
                <div class="flex border-[#909090] border-b pb-2 items-center gap-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="check-circle"
                        class="w-[15px] h-[15px]">
                        <path fill="#09697E"
                            d="M14.72,8.79l-4.29,4.3L8.78,11.44a1,1,0,1,0-1.41,1.41l2.35,2.36a1,1,0,0,0,.71.29,1,1,0,0,0,.7-.29l5-5a1,1,0,0,0,0-1.42A1,1,0,0,0,14.72,8.79ZM12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z">
                        </path>
                    </svg>
                    <p class="mr-2">Status</p>
                    <span>: {{ $dataMahasiswa->detailMahasiswa->status }}</span>
                </div>
                {{-- Progress Bar --}}
                <div class="mt-6">
                    <p class="text-sm font-semibold mb-2">Laporan terajukan</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-500 h-2.5 rounded-full"
                            style="width: {{ min($persentaseLaporan, 100) }}%">
                        </div>
                    </div>
                    <p class="text-xs mt-1">
                        {{ $laporanValid }}/{{ $totalTargetLaporan }}
                    </p>
                </div>
            </div>
        </aside>

        {{-- Main --}}
        <main class="w-[80%] px-6 py-5">
            <div class="mb-5">
                <h1 class="font-bold text-2xl">Dashboard Mahasiswa</h1>
                <p>Selamat Datang, {{ $dataMahasiswa->name }}</p>
                <button class="mt-2 bg-[#1D7D94] w-[150px] rounded-2xl text-[#F5F5F5] py-0.5 cursor-pointer">
                    Buat Laporan
                </button>
            </div>
            {{-- Laporan yg disimpan --}}
            <div class="bg-white w-full h-[300px] shadow-md rounded-md p-2 mb-5">
                <h2 class="font-semibold mb-3 text-lg">Laporan Monev Yang Tersimpan</h2>
                <table class="min-w-full text-sm shadow-md">
                    <thead>
                        <tr class="bg-[#E8BE00]">
                            <th class="px-4 py-2 text-center">No</th>
                            <th class="px-4 py-2 text-center">Semester</th>
                            <th class="px-4 py-2 text-center">Tahun Ajar</th>
                            <th class="px-4 py-2 text-center">Status</th>
                            <th class="px-4 py-2 text-center">Tanggal Dibuat</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($draftedLaporan as $drafted)
                            <tr class="bg-[#f8f8f8]"">
                                <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 text-center">{{ $drafted->semester ?? '-' }}</td>
                                <td class="px-4 py-2 text-center">
                                    {{ $drafted->periodeSemester?->tahun_akademik ?? '-' }}
                                    {{ $drafted->periodeSemester?->semester }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <span class="bg-[#cecece] px-2 py-0.5 rounded-lg">{{ $drafted->status }}</span>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    {{ $drafted->created_at ? $drafted->created_at->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('mahasiswa.lihat-laporan', $drafted->laporan_id) }}"
                                        class="underline">Lihat</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Laporan yg terkirim --}}
            <div class="bg-white w-full h-[300px] shadow-md rounded-md p-2">
                <h2 class="font-semibold mb-3 text-lg">Laporan Monev Yang Terkirim</h2>
                <table class="min-w-full text-sm shadow-md">
                    <thead>
                        <tr class="bg-[#E8BE00]">
                            <th class="px-4 py-2 text-center">No</th>
                            <th class="px-4 py-2 text-center">Semester</th>
                            <th class="px-4 py-2 text-center">Tahun Ajar</th>
                            <th class="px-4 py-2 text-center">Status</th>
                            <th class="px-4 py-2 text-center">Tanggal Dibuat</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendingLaporan as $pending)
                            <tr class="bg-[#f8f8f8]">
                                <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 text-center">{{ $pending->semester ?? '-' }}</td>
                                <td class="px-4 py-2 text-center">
                                    {{ $pending->periodeSemester?->tahun_akademik ?? '-' }}
                                    {{ $pending->periodeSemester?->semester }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <span class="bg-[#ffdd44] px-2 py-0.5 rounded-lg">{{ $pending->status }}</span>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    {{ $pending->created_at ? $pending->created_at->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('mahasiswa.detail-laporan', $pending->laporan_id) }}"
                                        class="underline">Lihat</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>

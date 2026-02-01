<aside
    class="w-full lg:w-[250px] bg-white flex-shrink-0 flex flex-col lg:fixed lg:top-0 lg:left-0 lg:h-screen shadow-lg z-20"
    x-data="{ sidebarOpen: false }">

    {{-- TOMBOL TOGGLE KHUSUS HP (Hidden di Desktop) --}}
    <div class="lg:hidden flex justify-between items-center p-4 border-b border-gray-200 cursor-pointer bg-white"
        @click="sidebarOpen = !sidebarOpen">
        <div class="flex items-center gap-2 font-bold text-[#09697E]">
            {{-- Icon Menu --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
            <span>Profile Mahasiswa</span>
        </div>
        {{-- Icon Panah (Berputar saat dibuka) --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform duration-200"
            :class="sidebarOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    {{-- ISI SIDEBAR --}}
    <div :class="sidebarOpen ? 'block' : 'hidden lg:block'" class="h-full overflow-y-auto">
        <div class="px-6 pt-20 pb-6 flex flex-col items-center border-b border-gray-200">
            {{-- Logo or Brand (Optional, keeping avatar as per original) --}}
            <img src="{{ $dataMahasiswa->avatar }}" alt="avatar-mhs"
                class="w-20 h-20 rounded-full object-cover border-4 border-[#E8BE00] shadow-sm mb-3">
            <h1 class="text-lg font-bold text-gray-800 text-center">{{ $dataMahasiswa->name }}</h1>
            <p class="text-sm text-[#09697E] font-medium text-center">{{ $dataMahasiswa->nim }}</p>
        </div>

        <div class="p-6 space-y-4 text-sm text-gray-600">
            {{-- Angkatan --}}
            <div class="flex items-center gap-3 group">
                <div
                    class="p-2 bg-gray-100 rounded-lg group-hover:bg-[#09697E] group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Angkatan</p>
                    <p class="font-semibold">{{ $dataMahasiswa->detailMahasiswa->angkatan }}</p>
                </div>
            </div>

            {{-- Prodi --}}
            <div class="flex items-center gap-3 group">
                <div
                    class="p-2 bg-gray-100 rounded-lg group-hover:bg-[#09697E] group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Prodi</p>
                    <p class="font-semibold">{{ $dataMahasiswa->detailMahasiswa->prodi }}</p>
                </div>
            </div>

            {{-- Kelas --}}
            <div class="flex items-center gap-3 group">
                <div
                    class="p-2 bg-gray-100 rounded-lg group-hover:bg-[#09697E] group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Kelas</p>
                    <p class="font-semibold">{{ $dataMahasiswa->detailMahasiswa->kelas }}</p>
                </div>
            </div>

            {{-- Beasiswa --}}
            <div class="flex items-center gap-3 group">
                <div
                    class="p-2 bg-gray-100 rounded-lg group-hover:bg-[#09697E] group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Beasiswa</p>
                    <p class="font-semibold truncate w-32"
                        title="{{ $dataMahasiswa->detailMahasiswa->jenis_beasiswa }}">
                        {{ $dataMahasiswa->detailMahasiswa->jenis_beasiswa }}
                    </p>
                </div>
            </div>

            {{-- Status --}}
            <div class="flex items-center gap-3 group">
                <div
                    class="p-2 bg-gray-100 rounded-lg group-hover:bg-[#09697E] group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Status</p>
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                        {{ $dataMahasiswa->detailMahasiswa->status }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Progress Bar --}}
        <div class="p-6 border-t border-gray-200 mt-auto">
            <p class="text-sm font-semibold mb-2 text-gray-700">Laporan terajukan</p>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-[#E8BE00] h-2.5 rounded-full transition-all duration-500"
                    style="width: {{ min($presentaseLaporan, 100) }}%">
                </div>
            </div>
            <p class="text-xs mt-2 text-right text-gray-500">
                <span class="font-bold text-[#09697E]">{{ $jumlahLaporanTerkirim }}</span> / {{ $totalLaporan }}
            </p>
        </div>
    </div>
</aside>
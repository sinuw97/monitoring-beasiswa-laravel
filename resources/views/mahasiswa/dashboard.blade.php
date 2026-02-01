@extends('mahasiswa.layout')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    {{-- Header Section --}}
    <div class="mb-8">
        <h1 class="font-bold text-3xl text-gray-800">Dashboard</h1>
        <p class="text-gray-600 mt-2">Selamat Datang, <span
                class="font-semibold text-[#09697E]">{{ $dataMahasiswa->name }}</span></p>
    </div>

    {{-- Running Text Info --}}
    @if($pengumuman)
        <div class="mb-8 bg-white rounded-lg shadow-sm border-l-4 border-[#09697E] p-4 flex items-center gap-4">
            <div class="p-2 bg-teal-50 rounded-lg text-[#09697E] flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                </svg>
            </div>
            <div class="flex-1 overflow-hidden relative h-6">
                <div class="animate-marquee whitespace-nowrap absolute top-0">
                    <span class="mr-10 font-medium text-gray-700">{{ $pengumuman }}</span>
                    <span class="mr-10 font-medium text-gray-700">{{ $pengumuman }}</span>
                    <span class="mr-10 font-medium text-gray-700">{{ $pengumuman }}</span>
                </div>
            </div>
        </div>
    @endif

    {{-- Call to Action & Info Card --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- Card Buat Laporan --}}
        <div
            class="bg-white rounded-xl shadow-md p-6 border-t-4 border-[#1D7D94] hover:shadow-lg transition-all duration-300">
            <div class="flex flex-col h-full justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-800 mb-2">Buat Laporan Monev</h2>
                    <p class="text-sm text-gray-500 mb-4">
                        Silahkan isi laporan monitoring evaluasi untuk periode yang sedang aktif. Laporan yang belum dikirim
                        akan tersimpan sebagai draft.
                    </p>
                </div>
                <a href="{{ route('mahasiswa.laporan-monev') }}"
                    class="inline-block w-full text-center bg-[#1D7D94] hover:bg-[#175e70] text-white font-semibold py-2.5 rounded-lg transition-colors duration-200">
                    Mulai Isi Laporan
                </a>
            </div>
        </div>

        {{-- Card Informasi Penting --}}
        <div class="bg-[#EAF6F8] rounded-xl p-6 border-l-4 border-[#E8BE00]">
            <div class="flex items-start gap-4">
                <div class="p-2 bg-white rounded-full text-[#E8BE00] shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-[#0F3F4A] mb-1">Informasi Penting</h3>
                    <p class="text-sm text-[#0F3F4A] leading-relaxed">
                        Pastikan Anda mengisi data dengan benar dan jujur. Jika ada kendala teknis, segera hubungi admin.
                        Laporan Monev dibuka sesuai jadwal akademik yang berlaku.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tables Section --}}
    <div class="space-y-8">

        {{-- Laporan Tersimpan (Draft) --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-800">Laporan Tersimpan (Draft)</h3>
                <span
                    class="px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-200 text-gray-600">{{ count($draftedLaporan) }}
                    Item</span>
            </div>

            {{-- Desktop Table --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 font-medium border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3">No</th>
                            <th class="px-6 py-3">Semester</th>
                            <th class="px-6 py-3">Tahun Ajar</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Tanggal Dibuat</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($draftedLaporan as $drafted)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3 font-medium text-gray-800">{{ $drafted->semester ?? '-' }}</td>
                                <td class="px-6 py-3">{{ $drafted->periodeSemester?->tahun_akademik ?? '-' }}
                                    {{ $drafted->periodeSemester?->semester }}</td>
                                <td class="px-6 py-3">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded bg-gray-200 text-gray-700 border border-gray-300">
                                        {{ $drafted->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-gray-500">
                                    {{ $drafted->created_at ? $drafted->created_at->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <a href="{{ route('mahasiswa.lihat-laporan', $drafted->laporan_id) }}"
                                        class="text-[#1D7D94] hover:text-[#0f4d5c] font-semibold text-sm hover:underline">
                                        Lanjutkan
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">Belum ada laporan tersimpan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="block lg:hidden divide-y divide-gray-100">
                @forelse ($draftedLaporan as $drafted)
                    <div class="p-4 bg-white">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span
                                    class="inline-block px-2 py-0.5 rounded text-xs font-semibold bg-gray-200 text-gray-700 mb-1">
                                    {{ $drafted->status }}
                                </span>
                                <h4 class="font-bold text-gray-800 ">Semester {{ $drafted->semester }}</h4>
                                <p class="text-xs text-gray-500">{{ $drafted->periodeSemester?->tahun_akademik }}</p>
                            </div>
                            <a href="{{ route('mahasiswa.lihat-laporan', $drafted->laporan_id) }}"
                                class="text-[#1D7D94] font-semibold text-sm">
                                Edit
                            </a>
                        </div>
                        <p class="text-xs text-gray-400 mt-2 text-right">
                            {{ $drafted->created_at ? $drafted->created_at->translatedFormat('d M Y') : '-' }}</p>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500 text-sm">Tidak ada data.</div>
                @endforelse
            </div>
        </div>

        {{-- Laporan Dikembalikan (Revisi) --}}
        @if(count($laporanDikembalikan) > 0)
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-blue-100">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-blue-50">
                    <h3 class="font-bold text-blue-800">Laporan Dikembalikan (Perlu Revisi)</h3>
                    <span
                        class="px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-200 text-blue-800">{{ count($laporanDikembalikan) }}
                        Item</span>
                </div>
                {{-- Desktop Table --}}
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 font-medium border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Semester</th>
                                <th class="px-6 py-3">Tahun Ajar</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Tanggal Revisi</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($laporanDikembalikan as $dikembalikan)
                                <tr class="hover:bg-blue-50/30 transition-colors">
                                    <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-3 font-medium text-gray-800">{{ $dikembalikan->semester ?? '-' }}</td>
                                    <td class="px-6 py-3">{{ $dikembalikan->periodeSemester?->tahun_akademik ?? '-' }}</td>
                                    <td class="px-6 py-3">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-700 border border-blue-200">
                                            {{ $dikembalikan->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-gray-500">
                                        {{ $dikembalikan->updated_at ? $dikembalikan->updated_at->translatedFormat('d F Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <a href="{{ route('mahasiswa.revisi-laporan', $dikembalikan->laporan_id) }}"
                                            class="px-3 py-1.5 bg-[#1D7D94] text-white text-xs font-bold rounded-lg hover:bg-[#125d6f] transition shadow-sm">
                                            Perbaiki
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Mobile List for Revisi --}}
                <div class="block lg:hidden divide-y divide-gray-100">
                    @foreach ($laporanDikembalikan as $dikembalikan)
                        <div class="p-4 bg-white border-l-4 border-blue-400">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span
                                        class="inline-block px-2 py-0.5 rounded text-xs font-semibold bg-blue-100 text-blue-700 mb-1">
                                        {{ $dikembalikan->status }}
                                    </span>
                                    <h4 class="font-bold text-gray-800">Semester {{ $dikembalikan->semester }}</h4>
                                </div>
                                <a href="{{ route('mahasiswa.revisi-laporan', $dikembalikan->laporan_id) }}"
                                    class="px-3 py-1 bg-[#1D7D94] text-white text-xs rounded shadow-sm">
                                    Perbaiki
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Laporan Terkirim --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-800">Riwayat Laporan Terkirim</h3>
                <span
                    class="px-2.5 py-0.5 rounded-md text-xs font-medium bg-green-100 text-green-700">{{ count($pendingLaporan) }}
                    Item</span>
            </div>

            {{-- Desktop Table --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 font-medium border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3">No</th>
                            <th class="px-6 py-3">Semester</th>
                            <th class="px-6 py-3">Tahun Ajar</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Tanggal Kirim</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($pendingLaporan as $pending)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3 font-medium text-gray-800">{{ $pending->semester ?? '-' }}</td>
                                <td class="px-6 py-3">{{ $pending->periodeSemester?->tahun_akademik ?? '-' }}</td>
                                <td class="px-6 py-3">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded bg-[#ffdd44] text-gray-900 border border-yellow-300">
                                        {{ $pending->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-gray-500">
                                    {{ $pending->created_at ? $pending->created_at->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <a href="{{ route('mahasiswa.detail-laporan', $pending->laporan_id) }}"
                                        class="text-[#1D7D94] hover:text-[#0f4d5c] font-semibold text-sm hover:underline">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">Belum ada riwayat laporan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile List for Terkirim --}}
            <div class="block lg:hidden divide-y divide-gray-100">
                @forelse ($pendingLaporan as $pending)
                    <div class="p-4 bg-white">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span
                                    class="inline-block px-2 py-0.5 rounded text-xs font-semibold bg-[#ffdd44] text-gray-900 mb-1">
                                    {{ $pending->status }}
                                </span>
                                <h4 class="font-bold text-gray-800">Semester {{ $pending->semester }}</h4>
                            </div>
                            <a href="{{ route('mahasiswa.detail-laporan', $pending->laporan_id) }}"
                                class="text-[#1D7D94] font-semibold text-sm">
                                Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500 text-sm">Tidak ada riwayat.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
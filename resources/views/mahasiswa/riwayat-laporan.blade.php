@extends('mahasiswa.layout')

@section('title', 'Riwayat Laporan Monev')

@section('content')
    <div class="mb-6">
        <h1 class="font-bold text-3xl text-gray-800">Riwayat Laporan Monev</h1>
        <p class="text-gray-600 mt-1">Menampilkan semua laporan yang telah kamu kirim.</p>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        {{-- Mobile View --}}
        <div class="block sm:hidden divide-y divide-gray-100">
            @forelse ($riwayatLaporan as $laporan)
                @php
                    $warnaStatus = match ($laporan->status) {
                        'Lolos', 'Lolos dengan penugasan' => 'bg-green-100 text-green-700 border-green-200',
                        'Pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                        'Dikembalikan' => 'bg-blue-100 text-blue-700 border-blue-200',
                        'Ditolak SP-1', 'Ditolak SP-2', 'Ditolak SP-3' => 'bg-red-100 text-red-700 border-red-200',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp

                <div class="p-4 bg-white">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <span
                                class="inline-block px-2 py-0.5 rounded text-xs font-semibold mb-1 border {{ $warnaStatus }}">
                                {{ $laporan->status }}
                            </span>
                            <h3 class="font-bold text-gray-800">Semester {{ $laporan->semester }}</h3>
                            <p class="text-xs text-gray-500">
                                {{ $laporan->periodeSemester?->tahun_akademik ?? '-' }} -
                                {{ $laporan->periodeSemester?->semester }}
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-between items-end mt-3">
                        <span class="text-xs text-gray-400">
                            {{ $laporan->created_at ? $laporan->created_at->translatedFormat('d F Y') : '-' }}
                        </span>

                        <div class="flex gap-2">
                            @if (in_array(strtolower($laporan->status), ['lolos', 'approved']))
                                <a href="{{ route('mahasiswa.laporan.export-pdf', $laporan->laporan_id) }}"
                                    class="px-3 py-1.5 text-xs bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition shadow-sm flex items-center"
                                    title="Export PDF">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </a>
                                <a href="{{ route('mahasiswa.laporan.export-docx', $laporan->laporan_id) }}"
                                    class="px-3 py-1.5 text-xs bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition shadow-sm flex items-center"
                                    title="Export Word">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </a>
                            @endif

                            @if ($laporan->status === 'Dikembalikan')
                                <a href="{{ route('mahasiswa.revisi-laporan', $laporan->laporan_id) }}"
                                    class="px-3 py-1.5 text-xs bg-[#1D7D94] text-white font-semibold rounded-md hover:bg-[#125d6f] transition shadow-sm">
                                    Revisi
                                </a>
                            @else
                                <a href="{{ route('mahasiswa.detail-laporan', $laporan->laporan_id) }}"
                                    class="px-3 py-1.5 text-xs bg-[#1D7D94] text-white font-semibold rounded-md hover:bg-[#125d6f] transition shadow-sm">
                                    Lihat
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-sm text-gray-500 py-8">
                    Tidak ada riwayat laporan.
                </div>
            @endforelse
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-[#ffdc3f] text-gray-600 font-medium border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-center w-16">No</th>
                        <th class="px-6 py-3">Semester</th>
                        <th class="px-6 py-3">Tahun Akademik</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3">Tanggal Dibuat</th>
                        <th class="px-6 py-3 text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($riwayatLaporan as $laporan)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 text-center">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 font-medium text-gray-800">{{ $laporan->semester ?? '-' }}</td>
                            <td class="px-6 py-3">
                                {{ $laporan->periodeSemester?->tahun_akademik ?? '-' }}
                                {{ $laporan->periodeSemester?->semester }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                @php
                                    $warnaStatus = match ($laporan->status) {
                                        'Lolos',
                                        'Lolos dengan penugasan'
                                            => 'bg-green-100 text-green-700 border-green-200',
                                        'Pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'Dikembalikan' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'Ditolak SP-1',
                                        'Ditolak SP-2',
                                        'Ditolak SP-3'
                                            => 'bg-red-100 text-red-700 border-red-200',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <span
                                    class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $warnaStatus }}">
                                    {{ $laporan->status }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-gray-500">
                                {{ $laporan->created_at ? $laporan->created_at->translatedFormat('d F Y') : '-' }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex justify-center items-center gap-3">
                                    @if (in_array(strtolower($laporan->status), ['lolos', 'approved']))
                                        <a href="{{ route('mahasiswa.laporan.export-pdf', $laporan->laporan_id) }}"
                                            class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition"
                                            title="Export PDF">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('mahasiswa.laporan.export-docx', $laporan->laporan_id) }}"
                                            class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition"
                                            title="Export Word">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </a>
                                    @endif

                                    @if ($laporan->status === 'Dikembalikan')
                                        <a href="{{ route('mahasiswa.revisi-laporan', $laporan->laporan_id) }}"
                                            class="text-[#1D7D94] hover:text-[#0f4d5c] font-semibold text-sm hover:underline">
                                            Revisi</a>
                                    @else
                                        <a href="{{ route('mahasiswa.detail-laporan', $laporan->laporan_id) }}"
                                            class="text-[#1D7D94] hover:text-[#0f4d5c] font-semibold text-sm hover:underline">
                                            Lihat</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        >>>>>>> 4aab94bcbd8ecdc3bf0074d5e63f1a9c8ac18d63
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">
                                Belum ada laporan yang dikirim.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

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
                            <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold mb-1 border {{ $warnaStatus }}">
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
            @empty
                <div class="text-center text-sm text-gray-500 py-8">
                    Tidak ada riwayat laporan.
                </div>
            @endforelse
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 font-medium border-b border-gray-200">
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
                                                    'Lolos', 'Lolos dengan penugasan' => 'bg-green-100 text-green-700 border-green-200',
                                                    'Pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                    'Dikembalikan' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                    'Ditolak SP-1', 'Ditolak SP-2', 'Ditolak SP-3' => 'bg-red-100 text-red-700 border-red-200',
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
                                            @if ($laporan->status === 'Dikembalikan')
                                                <a href="{{ route('mahasiswa.revisi-laporan', $laporan->laporan_id) }}"
                                                    class="text-[#1D7D94] hover:text-[#0f4d5c] font-semibold text-sm hover:underline">
                                                    Revisi</a>
                                            @else
                                                <a href="{{ route('mahasiswa.detail-laporan', $laporan->laporan_id) }}"
                                                    class="text-[#1D7D94] hover:text-[#0f4d5c] font-semibold text-sm hover:underline">
                                                    Lihat</a>
                                            @endif
                                        </td>
                                    </tr>
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
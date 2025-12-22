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

        #nprogress .bar {
            background: #09697E;
            height: 5px;
        }

        #nprogress .peg {
            box-shadow: 0 0 15px #09697E, 0 0 9px #09697E;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/nprogress/nprogress.css">
    <title>Riwayat Laporan Monev</title>
</head>

<body class="bg-[#F8F6F6]">
    {{-- Navbar --}}
    <x-navbar-mhs mhsAvatar='{{ $dataMahasiswa->avatar }}' />

    <section class="flex justify-center w-full px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-[#fdfdfd] w-full max-w-[1000px] h-auto p-4 sm:p-6 mt-4 rounded-lg shadow">
            <h2 class="text-xl lg:text-2xl font-bold mb-2 text-[#09697E]">Riwayat Laporan Monev</h2>
            <p class="text-sm sm:text-md text-gray-600 mb-4">
                Menampilkan semua laporan yang telah kamu kirim.
            </p>

            {{-- Mobile View --}}
            <div class="block sm:hidden space-y-4 mt-4 px-2">
                @forelse ($riwayatLaporan as $laporan)
                    @php
                        $warnaStatus = match ($laporan->status) {
                            'Lolos', 'Lolos dengan penugasan' => 'bg-[#27d360] text-[#FEFEFE]',
                            'Pending' => 'bg-[#ffdd44] text-[#0F0F0F]',
                            'Dikembalikan' => 'bg-[#2563EB] text-[#FEFEFE]',
                            'Ditolak SP-1', 'Ditolak SP-2', 'Ditolak SP-3' => 'bg-[#d13737] text-[#FEFEFE]',
                            default => 'bg-gray-300 text-[#0F0F0F]',
                        };
                    @endphp

                    <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-[#E8BE00]">

                        {{-- Header: Status & Tanggal --}}
                        <div class="flex items-center justify-between mb-3">
                            <span
                                class="inline-block text-[10px] font-semibold tracking-wide uppercase px-2 py-1 rounded {{ $warnaStatus }}">
                                {{ $laporan->status }}
                            </span>

                            <span class="text-[11px] italic text-gray-700">
                                {{ $laporan->created_at ? $laporan->created_at->translatedFormat('d F Y') : '-' }}
                            </span>
                        </div>

                        {{-- Semester --}}
                        <h3 class="text-md font-bold mb-1">
                            Semester {{ $laporan->semester }}
                        </h3>

                        {{-- Periode --}}
                        <p class="text-xs text-gray-600 mb-3">
                            Periode:
                            {{ $laporan->periodeSemester?->tahun_akademik ?? '-' }}
                            -
                            {{ $laporan->periodeSemester?->semester }}
                        </p>

                        {{-- Aksi --}}
                        <div class="flex justify-end">
                            @if ($laporan->status === 'Lolos' || $laporan->status === 'Pending' || str_contains($laporan->status, 'Ditolak'))
                                <a href="{{ route('mahasiswa.detail-laporan', $laporan->laporan_id) }}"
                                    class="px-3 py-1.5 text-xs bg-[#1D7D94] text-white font-semibold rounded-md hover:bg-[#09697E] transition">
                                    Lihat
                                </a>
                            @elseif ($laporan->status === 'Dikembalikan')
                                <a href="{{ route('mahasiswa.revisi-laporan', $laporan->laporan_id) }}"
                                    class="px-3 py-1.5 text-xs bg-[#1D7D94] text-white font-semibold rounded-md hover:bg-[#09697E] transition">
                                    Revisi
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center text-sm text-gray-500 py-6">
                        Tidak ada data
                    </div>
                @endforelse
            </div>

            {{-- Desktop View --}}
            <div class="hidden sm:block overflow-x-auto rounded-md">
                <table class="min-w-full text-xs sm:text-sm bg-white border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-[#E8BE00] text-gray-900">
                            <th class="px-3 sm:px-4 py-2 text-center">No</th>
                            <th class="px-3 sm:px-4 py-2 text-center">Semester</th>
                            <th class="px-3 sm:px-4 py-2 text-center">Tahun Akademik</th>
                            <th class="px-3 sm:px-4 py-2 text-center">Status</th>
                            <th class="px-3 sm:px-4 py-2 text-center">Tanggal Dibuat</th>
                            <th class="px-3 sm:px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayatLaporan as $laporan)
                            <tr class="odd:bg-[#f8f8f8] even:bg-[#f2f2f2] hover:bg-[#f1f1f1] transition">
                                <td class="px-3 sm:px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                <td class="px-3 sm:px-4 py-2 text-center">{{ $laporan->semester ?? '-' }}</td>
                                <td class="px-3 sm:px-4 py-2 text-center">
                                    {{ $laporan->periodeSemester?->tahun_akademik ?? '-' }}
                                    {{ $laporan->periodeSemester?->semester }}
                                </td>
                                <td class="px-3 sm:px-4 py-2 text-center">
                                    @php
                                        $warnaStatus = match ($laporan->status) {
                                            'Lolos', 'Lolos dengan penugasan' => 'bg-[#27d360] text-[#FEFEFE]',
                                            'Pending' => 'bg-[#ffdd44] text-[#0F0F0F]',
                                            'Dikembalikan' => 'bg-[#2563EB] text-[#FEFEFE]',
                                            'Ditolak SP-1',
                                            'Ditolak SP-2',
                                            'Ditolak SP-3'
                                                => 'bg-[#d13737] text-[#FEFEFE]',
                                            default => 'bg-gray-300 text-[#0F0F0F]',
                                        };
                                    @endphp
                                    <span
                                        class="inline-block px-2 py-0.5 rounded-md font-semibold text-xs sm:text-sm {{ $warnaStatus }}
               max-w-[80px] sm:max-w-none truncate text-center leading-tight">
                                        {{ $laporan->status }}
                                    </span>
                                </td>
                                <td class="px-3 sm:px-4 py-2 text-center whitespace-nowrap">
                                    {{ $laporan->created_at ? $laporan->created_at->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="px-3 sm:px-4 py-2 text-center">
                                    {{-- Conditional Rendering --}}
                                    @if ($laporan->status === 'Lolos' || $laporan->status === 'Pending' || $laporan->status === 'Ditolak')
                                        <a href="{{ route('mahasiswa.detail-laporan', $laporan->laporan_id) }}"
                                            class="px-2 py-1 bg-[#1D7D94] text-[#fdfcfc] font-bold rounded-md hover:bg-[#09697E] transition-all">
                                            Lihat</a>
                                    @elseif($laporan->status === 'Dikembalikan')
                                        <a href="{{ route('mahasiswa.revisi-laporan', $laporan->laporan_id) }}"
                                            class="px-2 py-1 bg-[#1D7D94] text-[#fdfcfc] font-bold rounded-md hover:bg-[#09697E] transition-all">
                                            Lihat</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                    Belum ada laporan yang dikirim.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
    </section>

    {{-- Progress Bar --}}
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

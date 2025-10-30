<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <title>Riwayat Laporan Monev</title>
</head>

<body class="bg-[#F8F6F6]">
    {{-- Navbar --}}
    <x-navbar-mhs mhsAvatar='{{ $dataMahasiswa->avatar }}' />

    <section class="flex justify-center w-full h-auto">
        <div class="bg-[#fdfdfd] w-[1000px] h-auto p-6 mt-4 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-2 text-[#09697E]">Riwayat Laporan Monev</h2>
            <p class="text-md text-gray-600 mb-4">Menampilkan semua laporan yang telah kamu kirim.</p>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm shadow-md bg-white border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-[#E8BE00]">
                            <th class="px-4 py-2 text-center">No</th>
                            <th class="px-4 py-2 text-center">Semester</th>
                            <th class="px-4 py-2 text-center">Tahun Akademik</th>
                            <th class="px-4 py-2 text-center">Status</th>
                            <th class="px-4 py-2 text-center">Tanggal Dibuat</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayatLaporan as $laporan)
                            <tr class="odd:bg-[#f8f8f8] even:bg-[#f2f2f2] hover:bg-[#f1f1f1]">
                                <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 text-center">{{ $laporan->semester ?? '-' }}</td>
                                <td class="px-4 py-2 text-center">
                                    {{ $laporan->periodeSemester?->tahun_akademik ?? '-' }}
                                    {{ $laporan->periodeSemester?->semester }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    @php
                                        $warnaStatus = match ($laporan->status) {
                                            'Lolos' => 'bg-[#27d360] text-white',
                                            'Pending' => 'bg-[#ffdd44] text-black',
                                            'Rejected', 'Ditolak SP-1', 'Ditolak' => 'bg-[#d13737] text-white',
                                            default => 'bg-gray-300 text-black',
                                        };
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-lg font-semibold {{ $warnaStatus }}">
                                        {{ $laporan->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    {{ $laporan->created_at ? $laporan->created_at->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ route('mahasiswa.detail-laporan', $laporan->laporan_id) }}"
                                        class="px-3 py-1 bg-[#2179ca] text-white rounded-md hover:bg-[#1c6bb4] transition-all">
                                        Lihat
                                    </a>
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
        </div>
    </section>
</body>

</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <title>Pengisian Monev</title>
</head>

<body class="bg-[#F8F6F6]">
    <x-navbar-mhs mhsAvatar='{{ $dataMahasiswa->avatar }}' />

    <section class="flex justify-center w-full h-auto">
        <div class="bg-[#fdfdfd] w-[1000px] h-auto p-6">
            <h2 class="text-xl font-bold ml-3.5 mb-2">Pengisian Laporan Monev</h2>

            @if ($periodeAktifBanner)
                <div class="bg-blue-100 border-l-4 border-blue-600 text-blue-800 p-4 rounded-lg mx-4 mb-4">
                    <p class="font-semibold">
                        Periode {{ $periodeAktifBanner->tahun_akademik }} {{ $periodeAktifBanner->semester }} sedang
                        Dibuka
                    </p>
                </div>
            @endif

            <div class="overflow-x-auto mt-4">
                <table class="min-w-full text-sm shadow-lg bg-white border-separate border-spacing-0 m-4">
                    <thead>
                        <tr class="bg-[#E8BE00]">
                            <th class="px-4 py-2 text-center">No</th>
                            <th class="px-4 py-2 text-center">Semester</th>
                            <th class="px-4 py-2 text-center">Periode</th>
                            <th class="px-4 py-2 text-center">Status</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($timeline as $row)
                            <tr class="bg-[#f8f8f8]">
                                <td class="px-4 py-2 text-center">{{ $row['no'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $row['semester'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $row['periode'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $row['status'] }}</td>
                                <td class="px-4 py-2 text-center">
                                    @if ($row['status'] === 'Ditutup')
                                        <button type="button"
                                            class="px-2 py-1 bg-red-600 text-white font-bold rounded cursor-default opacity-60">
                                            Tutup
                                        </button>
                                    @elseif ($row['status'] === 'Dibuka')
                                        @if ($row['aksi'] === 'Buat')
                                            <form
                                                action="{{ route('mahasiswa.buat-laporan', [
                                                    'semesterId' => $row['semester_id'],
                                                    'semesterSekarang' => $row['semester'],
                                                ]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="px-2 py-1 bg-blue-700 text-white font-bold rounded hover:bg-blue-800">
                                                    Buat
                                                </button>
                                            </form>
                                        @elseif ($row['aksi'] === 'Lihat')
                                            <a href="{{ route('mahasiswa.detail-laporan', $row['laporan_id']) }}"
                                                class="px-2 py-1 bg-green-600 text-white font-bold rounded hover:bg-green-700">
                                                Lihat
                                            </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($timeline) }}" class="px-4 py-4 text-center ">
                                    Tidak ada data
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

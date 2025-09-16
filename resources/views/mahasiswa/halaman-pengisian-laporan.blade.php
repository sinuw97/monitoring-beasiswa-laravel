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
            <h2 class="text-xl font-bold mb-2">Pengisian Laporan Monev</h2>

            @if ($periodeAktif)
                <div class="w-full h-[50px] bg-blue-200 mb-2 px-3 py-3">
                    <p>
                        Periode {{ $periodeAktif->tahun_akademik }} {{ $periodeAktif->semester }} Telah Dibuka
                    </p>
                </div>
            @endif

            <div class="overflow-x-auto mt-4">
                <table class="min-w-full text-sm">
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
                            <tr class="bg-[#E7E6E6]">
                                @foreach ($row as $cell)
                                    <td class="px-4 py-2 text-center">{{ $cell }}</td>
                                @endforeach
                                <td class="px-4 py-2 text-center">
                                    @if ($cell !== 'Dibuka')
                                        <button type="button"
                                            class="px-3 py-1 bg-[#E8BE00] text-[#09697E] font-semibold rounded cursor-pointer">Lihat</button>
                                    @elseif ($cell === 'Dibuka')
                                        <form action="{{ route('mahasiswa.buat-laporan') }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1 bg-[#09697E] text-white font-semibold rounded cursor-pointer">Buat</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($timrline) }}" class="px-4 py-4 text-center ">
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

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
    <title>Pengisian Monev</title>
</head>

<body class="bg-[#F8F6F6]">
    <x-navbar-mhs mhsAvatar='{{ $dataMahasiswa->avatar }}' />

    <section class="flex justify-center w-full">
        <div class="bg-[#fdfdfd] w-full max-w-[1000px] p-4 sm:p-6">

            <h2 class="text-lg sm:text-xl font-bold ml-2 sm:ml-3.5 mb-2">
                Pengisian Laporan Monev
            </h2>

            {{-- Banner Card --}}
            @if ($periodeAktifBanner)
                <div
                    class="bg-[#09697e41] border-[#09697E] rounded-sm shadow-md border-l-4 p-3 sm:p-4 mx-2 sm:mx-4 mb-4">
                    <p class="font-semibold text-sm sm:text-base">
                        Periode {{ $periodeAktifBanner->tahun_akademik }} {{ $periodeAktifBanner->semester }} sedang
                        Dibuka
                    </p>
                    <p class="font-bold text-base sm:text-lg">
                        Waktu periode:
                        {{ \Carbon\Carbon::parse($periodeAktifBanner->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}
                        -
                        {{ \Carbon\Carbon::parse($periodeAktifBanner->tanggal_selesai)->locale('id')->translatedFormat('d F Y') }}
                    </p>
                </div>
            @endif

            {{-- ================= Mobile View ================= --}}
            <div class="block sm:hidden space-y-4 mt-4 px-2">
                @forelse ($timeline as $row)
                    <div
                        class="bg-white rounded-lg shadow-sm p-4 border-l-4
            {{ $row['status'] === 'Dibuka' ? 'border-[#1D7D94]' : 'border-red-400' }}">

                        {{-- Status --}}
                        <span
                            class="inline-block mb-2 text-[10px] font-semibold tracking-wide uppercase px-2 py-1 rounded
                {{ $row['status'] === 'Dibuka' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                            {{ $row['status'] }}
                        </span>

                        {{-- Semester (Judul) --}}
                        <h3 class="text-md font-bold mb-1">
                            {{ $row['semester'] }}
                        </h3>

                        {{-- Periode --}}
                        <p class="text-xs italic text-gray-600 mb-4">
                            Periode: {{ $row['periode'] }}
                        </p>

                        {{-- Aksi Btn --}}
                        <div class="flex justify-end">
                            @if ($row['status'] === 'Ditutup')
                                <button
                                    class="px-2.5 py-1 text-xs bg-red-500 text-[#FEFEFE] font-semibold rounded-md opacity-70 cursor-default">
                                    Tutup
                                </button>
                            @elseif ($row['aksi'] === 'Buat')
                                <form
                                    action="{{ route('mahasiswa.buat-laporan', [
                                        'semesterId' => $row['semester_id'],
                                        'semesterSekarang' => $row['semester'],
                                    ]) }}"
                                    method="POST">
                                    @csrf
                                    <button
                                        class="px-3.5 py-1 text-xs bg-[#2B6EE3] text-[#FEFEFE] font-semibold rounded-md hover:bg-[#0A80DA] transition">
                                        Buat
                                    </button>
                                </form>
                            @elseif ($row['aksi'] === 'Lihat')
                                <a href="{{ route('mahasiswa.lihat-laporan', $row['laporan_id']) }}"
                                    class="px-3 py-1 text-xs bg-[#1D7D94] text-[#FEFEFE] font-semibold rounded-md hover:bg-[#09697E] transition">
                                    Lihat
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center text-sm text-gray-500">
                        Tidak ada data
                    </div>
                @endforelse
            </div>


            {{-- ================= Desktop View ================= --}}
            <div class="hidden sm:block overflow-x-auto mt-4">
                <table class="min-w-[600px] w-full text-sm shadow-lg bg-white border-separate border-spacing-0 m-4">
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
                            <tr class="odd:bg-[#f8f8f8] even:bg-[#f2f2f2] hover:bg-[#f1f1f1] font-semibold">
                                <td class="px-4 py-2 text-center">{{ $row['no'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $row['semester'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $row['periode'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $row['status'] }}</td>
                                <td class="px-4 py-2 text-center">
                                    @if ($row['status'] === 'Ditutup')
                                        <button
                                            class="px-1.5 py-1 bg-red-600 text-[#FEFEFE] font-bold rounded opacity-60 cursor-default">
                                            Tutup
                                        </button>
                                    @elseif ($row['aksi'] === 'Buat')
                                        <form
                                            action="{{ route('mahasiswa.buat-laporan', [
                                                'semesterId' => $row['semester_id'],
                                                'semesterSekarang' => $row['semester'],
                                            ]) }}"
                                            method="POST">
                                            @csrf
                                            <button
                                                class="px-2.5 py-1 bg-[#1298FF] text-[#FEFEFE] font-bold rounded hover:bg-[#0A80DA] transition">
                                                Buat
                                            </button>
                                        </form>
                                    @elseif ($row['aksi'] === 'Lihat')
                                        <a href="{{ route('mahasiswa.lihat-laporan', $row['laporan_id']) }}"
                                            class="px-2 py-1 bg-[#1D7D94] text-[#FEFEFE] font-bold rounded hover:bg-[#09697E] transition">
                                            Lihat
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center">
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </section>

    <script src="https://unpkg.com/nprogress/nprogress.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            NProgress.start()
        });

        window.addEventListener('load', () => {
            NProgress.done()
        });

        document.addEventListener('submit', function() {
            NProgress.start()
        });
    </script>
</body>

</html>
